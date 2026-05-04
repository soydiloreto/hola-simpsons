# Testing & quality

What every quality gate enforces, why, and how to run each one locally.

## Quality stack at a glance

| Layer | Tool | Catches | CI workflow | Make target |
| --- | --- | --- | --- | --- |
| Unit tests | PHPUnit | Logic regressions in pure-PHP units (currently `hola_simpsons_pick_locale`). | `pr-checks.yml` | `make test` |
| Coding style | PHP_CodeSniffer + WordPress Coding Standards | Style, naming, escaping, sanitisation, deprecated APIs, prefix discipline. | `pr-checks.yml` | `make lint` |
| Static analysis | PHPStan level 8 + szepeviktor/phpstan-wordpress | Type safety, unreachable code, undefined methods/properties, missing return types. **No baseline.** | `tests-stan.yml` | `make stan` |
| Security taint analysis | Psalm + humanmade/psalm-plugin-wordpress (taint-only mode) | XSS, SQL injection, command injection — user input flowing into dangerous sinks. | `psalm-taint.yml` | `make psalm` |
| i18n | `wp i18n make-pot` | Missing translator comments on placeholders, dynamic text domains, conflicting translator hints, concat'd translatable strings. | `i18n-validate.yml` | `make i18n` |
| Plugin Check (wp.org) | wordpress/plugin-check | The same checks the wp.org plugin team runs at submission/review time. | `pr-checks.yml` | (no Make target — runs on PR) |
| PHP syntax matrix | `php -l` on PHP 7.0–8.3 | Hard syntax errors on every supported PHP version. | `pr-checks.yml` | (no Make target — runs on PR) |

Every layer must pass before a PR can land on `main` (branch protection enforces it).

## Unit tests

Located in [`tests/Unit/`](../tests/Unit/). They run in pure PHP without WordPress — the bootstrap stubs the two file-scope `add_action` calls in `hola-simpsons.php` so the plugin file can be required and its functions exercised directly.

```bash
make test           # default target → unit tests only
make test-unit      # explicit
```

The current suite covers `hola_simpsons_pick_locale()` — the only piece of pure logic in the plugin. Locale picking is the one place a regression would be invisible until a user with a non-curated locale notices the wrong language; the test makes that contract explicit.

When you add a new test:

- Mirror the source path: a new helper function `hola_simpsons_foo()` in `hola-simpsons.php` lives next to the others, but its tests go in `tests/Unit/FooTest.php`.
- Don't touch `$_GET`, `$_POST`, the database, the filesystem, or `define()` plugin constants. The bootstrap intentionally keeps the WP runtime out of the test environment.

## PHPCS / WordPress Coding Standards

Configuration: [`phpcs.xml.dist`](../phpcs.xml.dist).

```bash
make lint           # report violations
make lint-fix       # auto-fix what can be auto-fixed (PHPCBF)
```

The ruleset enforces the WordPress Coding Standards plus a small project-specific overlay:

- **Yoda conditions** are off (we use `$x === 5`, not `5 === $x`).
- A few cosmetic comment-formatting rules are relaxed.
- The plugin function-prefix is `hola_simpsons` (enforced by `WordPress.NamingConventions.PrefixAllGlobals`).
- The text domain is `hola-simpsons`.
- PHP compatibility is checked against PHP 7.0+ via `PHPCompatibilityWP`.

When PHPCS reports a violation, the rule code is in the right column. Search for it in the config or in [WPCS docs](https://github.com/WordPress/WordPress-Coding-Standards/wiki) before suppressing — most warnings are real bugs (missing escaping, missing nonce, missing prepare).

## PHPStan

Configuration: [`phpstan.neon`](../phpstan.neon).

```bash
make stan
```

We run **level 8 (max strictness) with no baseline.** Every type error must be fixed in code, not suppressed. The `szepeviktor/phpstan-wordpress` extension teaches PHPStan about the WordPress API surface so e.g. `get_user_locale()` returns `string` and `wp_remote_get()` returns `array|WP_Error`.

`WP_DEBUG` is declared `dynamicConstantNames` so PHPStan doesn't collapse `if ( WP_DEBUG )` into "always false" — its runtime value is set per-deployment from `wp-config.php`.

If you find a real type error PHPStan can't see (e.g. PHP extension stubs are missing in CI), use `// @phpstan-ignore-next-line <identifier>` with a comment explaining why. Don't add to a baseline — the project deliberately doesn't have one.

## Psalm taint analysis

Configuration: [`psalm.xml`](../psalm.xml).

```bash
make psalm
```

Psalm here runs in **taint-analysis mode only**. The `humanmade/psalm-plugin-wordpress` plugin teaches it that `esc_html()`, `esc_attr()`, `esc_url()`, `wpdb->prepare()`, `sanitize_*()` are sanitisation barriers, so user-controlled values from `$_GET` / `$_POST` / `$_REQUEST` / `$_COOKIE` / `$_FILES` / `$_SERVER` only become findings if they reach a dangerous sink (`echo`, `eval`, `exec`, `$wpdb->query()`, `file_put_contents`, `header`, …) without passing through one.

General static type-checking is suppressed in `psalm.xml` — that's PHPStan's job. Running both as type-checkers would just duplicate failures and obscure real taint findings.

The plugin currently has no user-input surface (no forms, no AJAX, no REST routes), so Psalm's taint findings should be zero. If a future change introduces user input, Psalm is what stops a missed escaper from shipping.

## i18n validation

Configuration: [`.github/workflows/i18n-validate.yml`](../.github/workflows/i18n-validate.yml).

```bash
make i18n
```

The Makefile target runs `wp i18n make-pot` and writes the result to `build/hola-simpsons.pot`. The CI workflow does the same and additionally fails the build if any `Warning:` / `Error:` line appears in the output (WP-CLI prints them to stderr but exits 0 even when present, so we capture the output and grep ourselves).

The workflow catches three real classes of bug:

- **Missing translator comments** on `sprintf()` placeholders. WordPress requires a `/* translators: %s: ... */` comment **on the line immediately preceding** the translation function call — separating it with a blank line silently makes it invisible to gettext.
- **Conflicting translator comments** on the same msgid.
- **Concat of translatable strings** like `__('Hello ') . __(' world')`, **dynamic text domains** like `__($string, $variable)`, and other hard-to-translate patterns.

Plugin Check (the wp.org-side validator) catches a partly overlapping but distinct subset, so both run on every PR.

## Plugin Check

CI step in [`pr-checks.yml`](../.github/workflows/pr-checks.yml). Runs the [official WordPress Plugin Check](https://github.com/WordPress/plugin-check-action) action with all categories enabled (`plugin_repo`, `security`, `performance`, `accessibility`, `general`) plus experimental checks. Some codes are explicitly ignored (`hidden_files`, `github_directory`, `unexpected_markdown_file`, `stable_tag_mismatch`) because they false-positive on the GitHub-flat repo layout or on the `-dev` suffix workflow.

If you ever submit a new version of the plugin to wp.org, the same checks run there. CI catches them earlier so a wp.org reviewer never has to.

## Running everything at once

```bash
make check     # lint + stan + psalm + tests
make release   # make check + version-alignment dry-run
```

`make release` is what you should run before pushing a release tag — it's the closest you can get to "what CI will say" without actually pushing.
