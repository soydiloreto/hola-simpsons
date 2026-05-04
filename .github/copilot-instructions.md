# Copilot custom instructions — Hola Simpsons

This file is the project-wide context for GitHub Copilot (Code Review,
Chat, Coding Agent, and any other surface that reads
`.github/copilot-instructions.md`). It encodes the conventions and
review priorities specific to this codebase. It is **not** generic
WordPress advice — it reflects how this plugin is actually written.

When you review a pull request, follow these rules. When in doubt,
prefer the project's existing patterns over textbook WordPress
patterns.

---

## What this repo is

A small WordPress plugin that prints a random quote from "The Simpsons"
in the WordPress admin area on every page load (similar in spirit to
the classic "Hello Dolly" plugin). Quotes are localised: the plugin
auto-selects the quote set based on the user's WordPress locale and
falls back through language family before defaulting to LATAM Spanish.

The whole plugin is a single PHP file (`hola-simpsons.php`, ~230
lines). There is no admin UI, no settings page, no database, no REST
endpoints, no cron, no AJAX, no asset bundle, no class hierarchy. It
hooks `admin_notices` and `admin_head`, prints HTML and inline CSS,
and that's it.

GPL-2.0-or-later. The maintainer is Pablo Diloreto
([@soydiloreto](https://github.com/soydiloreto)).

---

## Architecture quick-reference

| Path | Contains |
|------|----------|
| `hola-simpsons.php` | The entire plugin. Plugin header, four functions, two `add_action` calls. |
| `readme.txt` | wp.org plugin page content (description, FAQ, changelog). |
| `.wordpress-org/` | Banner / icon / screenshots for the wp.org listing. NOT runtime assets — uploaded to SVN `/assets/`, never to `/trunk/`. |

The four functions in `hola-simpsons.php`:

| Function | Role |
|----------|------|
| `hola_simpsons_quotes_data()` | Returns a per-locale `array<string, string>` of newline-separated quote blocks. The keys are WP locales (`es`, `en_US`, `es_ES`, `pt_BR`, `it_IT`). |
| `hola_simpsons_pick_locale( $user_locale )` | Pure function. Maps a WP locale (e.g. `en_GB`) to the closest available quote-set key, with a final fallback to `es`. **This is the only function that's testable as a pure unit** (does not touch WP state). |
| `hola_simpsons_get_quotes()` | Reads the user's locale via `get_user_locale()`, picks the set, returns `[ 'text' => ..., 'lang' => ... ]`. |
| `hola_simpsons()` | Renders the `<p id="simpsons">` markup hooked on `admin_notices`. |

Plus `hola_simpsons_css()` hooked on `admin_head` for the styling
block.

All function names are prefixed `hola_simpsons_` to satisfy the WPCS
`PrefixAllGlobals` sniff and the wp.org Plugin Check.

---

## Hard rules to enforce

Flag a PR if any of these are violated.

### Security

- **All output must be escaped.** The single output point is the
  `printf` in `hola_simpsons()`. The translatable label goes through
  `esc_html__`, and the dynamic locale code goes through `esc_attr`.
  The quote text itself is from the in-file constant array — it is
  **not** user-controlled — so it is rendered without escaping (it
  contains punctuation that would be mangled by `esc_html`). If a
  future change moves the quotes into an option, a transient, or a
  remote API, the rendering MUST switch to `wp_kses` or `esc_html`
  with the appropriate allowed-tags policy.
- **No user input is processed.** There is no form, no `$_GET`, no
  `$_POST`, no admin-post action, no AJAX handler, no REST route, no
  shortcode. If a PR introduces any of these surfaces, it MUST also
  introduce nonce verification, capability checks, and input
  sanitisation. Don't accept "this is just a tiny plugin" as a reason
  to skip them.
- **No direct file access.** This plugin is so small it doesn't even
  need an `if ( ! defined( 'ABSPATH' ) ) { exit; }` guard — there's
  nothing to leak. If a PR splits the plugin into multiple files,
  every newly-introduced file MUST start with that guard.

### WordPress conventions

- **Hooks only.** Output happens through `add_action( 'admin_notices'
  )` and `add_action( 'admin_head' )`. Don't invoke functions at file
  scope. Don't print at file scope.
- **Internationalisation.** The text domain is `hola-simpsons`. The
  user-facing screen-reader string uses `esc_html__( ..., 'hola-simpsons' )`.
  Quote bodies are intentionally NOT wrapped in `__()` — they are
  literal cultural artefacts (the Simpsons in five locales) chosen
  per-locale by `hola_simpsons_pick_locale()`, not strings to be
  translated.
- **PHP 7.0 minimum.** The `Requires PHP:` header says 7.0 and we
  honour it. Avoid syntax or functions added in 7.1+ unless the
  PHPCompatibility ruleset is happy. Examples of what NOT to use:
  nullable types (`?string`), void return type, `[$a, $b] =` array
  destructuring, class constant visibility, multi-catch.
- **Deterministic prefix.** Every global function and every defined
  constant must start with `hola_simpsons_` (lowercase) or
  `HolaSimpsons` (PascalCase for any future class). PHPCS enforces
  this via `WordPress.NamingConventions.PrefixAllGlobals`.

### Style

- **Modern conditions.** No Yoda. `$x === 5`, not `5 === $x`. The
  PHPCS config has the Yoda sniff explicitly disabled.
- **`wptexturize()` on quote text.** The current code calls
  `wptexturize` on the chosen quote before output. Keep it — it's
  what turns straight quotes into curly quotes and en/em dashes
  correctly per locale.
- **`mt_rand` is fine here.** The quote selection is not security
  sensitive. Don't suggest `random_int` "for security" — it is a
  cosmetic random pick, not a token generator.

### Translator comments

- If a PR adds a `sprintf` with a placeholder inside a translation
  function, the `/* translators: %s: ... */` comment MUST be on the
  line **immediately preceding** the translation call. A blank line
  in between makes the comment invisible to gettext. The
  `i18n-validate.yml` workflow runs `wp i18n make-pot` and fails
  the build on any `Warning:` it prints.

---

## Style rules NOT to comment on

Don't waste review comments on these — they are deliberate project
choices:

- **No Yoda conditions.** PHPCS rule already disabled.
- **Quote bodies are not in `__()`.** This is a deliberate locale
  selection, not a string-extraction omission.
- **No `ABSPATH` guard at the top of `hola-simpsons.php`.** The plugin
  has no helper files, no class files, nothing to leak. The guard
  would be cargo-culted defence-in-depth that doesn't defend anything.
- **Inline CSS in `hola_simpsons_css()`.** It's 25 lines. Splitting
  it into an `assets/css/admin.css` and enqueuing it through
  `wp_enqueue_style` would 5× the surface area of the plugin for no
  practical benefit. We accept the inline style as a deliberate
  small-plugin tradeoff.

---

## What to actively look for in PRs

In priority order:

1. **Missing escaping** if a PR adds any new output point. The
   existing `printf` is the template — match its escaping discipline.
2. **Missing prefix** on any new global function or constant.
3. **PHP 7.0 incompatibility** — anything in 7.1+ syntax flagged by
   PHPCompatibility is automatic-reject.
4. **Translator comments** placed on the wrong line (separated by a
   blank line from the translation call).
5. **Unbounded growth.** This plugin is intentionally tiny. A PR that
   refactors it into a dozen classes, an autoloader, and a settings
   page should be questioned in detail before being approved. The
   current shape (one file, four functions) is a feature, not a bug.

---

## Versioning and the `-dev` suffix

The PHP `Version:` header in `hola-simpsons.php` carries a `-dev`
suffix on `main` between releases (e.g. `1.4.0-dev`). The
`Stable tag:` in `readme.txt` does not — it always holds the last
published release. The CI version-alignment rule strips the suffix
when comparing, and the deploy workflow enforces strict equality at
tag time. See [`docs/release.md`](../docs/release.md) for the full
flow.

---

## Out of scope

- **No new features without an issue.** Drive-by feature PRs that
  weren't agreed upfront are usually closed politely. The plugin's
  scope is "print a Simpsons quote in the admin"; significant scope
  expansion needs a discussion first.
- **No dependency additions.** The published plugin has zero
  production dependencies and that's a hard line. Dev tooling
  dependencies in `composer.json` / `package.json` are fine — those
  never ship to wp.org.
