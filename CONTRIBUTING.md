# Contributing to Hola Simpsons

Thanks for your interest in contributing. This document covers how to report issues, submit pull requests, and what to expect from the review process.

## Reporting bugs and requesting features

Open a [new issue](https://github.com/soydiloreto/hola-simpsons/issues/new). Useful kinds of issue:

- **Bug report** — something is broken or behaves unexpectedly.
- **New quote** — a great Simpsons line that's missing from one of the curated sets.
- **New locale set** — you'd like the plugin to support a locale family (`fr_FR`, `de_DE`, `ja`, …) that currently falls back to LATAM Spanish.
- **Feature request** — you'd like the plugin to do something it doesn't do today.

For **end-user support questions** please use the [wp.org support forum](https://wordpress.org/support/plugin/hola-simpsons/) instead — that's where most users look for answers.

For **security vulnerabilities**, see [SECURITY.md](SECURITY.md). Do not open a public issue.

## Pull request workflow

1. **Fork** the repository and clone your fork locally.
2. **Branch** from `main` using a descriptive name following the convention below.
3. **Commit** your changes (see commit message conventions below).
4. **Push** the branch to your fork.
5. **Open a pull request** against `main`. Explain *why* the change matters, not just *what* it does.
6. **Wait for CI to pass.** All required checks must be green before review.
7. **Address review feedback** by pushing additional commits to the same branch (we squash on merge, so commit count doesn't matter).

### Branch naming

Use one of these prefixes, followed by a short kebab-case description:

| Prefix | Used for |
|--------|----------|
| `feat/` | New user-visible functionality (new locale set, new quote group, …) |
| `fix/` | Bug fixes |
| `chore/` | Maintenance tasks, version bumps, no behavior change |
| `docs/` | Documentation-only changes |
| `ci/` | CI/CD configuration changes |
| `refactor/` | Internal restructure with no behavior change |
| `style/` | Code style / linter / formatting changes |

Examples: `feat/french-quotes`, `fix/locale-fallback-edge-case`, `docs/readme-cleanup`.

### Commit messages

We follow [Conventional Commits](https://www.conventionalcommits.org/). The first line is `<type>(<optional-scope>): <subject>`, where type is one of `feat`, `fix`, `chore`, `docs`, `ci`, `refactor`, `style`, `test`. Examples:

```
feat(locales): add curated French quote set
fix: route es_AR through es key, not es_ES
chore: bump to 1.4.0
```

The body explains the *why* — context, motivation, alternatives considered. Wrap at ~72 characters.

## Coding conventions

The project enforces a strict quality stack on every PR. Run `make check` locally before pushing — it runs the same gates CI does.

| Gate | Tool | Make target |
| --- | --- | --- |
| Code style | PHP_CodeSniffer + WordPress Coding Standards | `make lint` (auto-fix: `make lint-fix`) |
| Static analysis | PHPStan level 8, no baseline | `make stan` |
| Security taint analysis | Psalm in taint-only mode (XSS, SQLi, RCE) | `make psalm` |
| i18n | `wp i18n make-pot` + warning-grep | `make i18n` |
| Unit tests | PHPUnit | `make test` |

See [`docs/testing-and-quality.md`](docs/testing-and-quality.md) for what each layer enforces and the configuration files that drive it.

A few hard rules the linters can't fully express:

- **PHP 7.0+** is the minimum supported version. Do not use syntax or functions added in later versions without a fallback. (PHPCS's PHPCompatibility ruleset catches most of this.)
- **No hard dependencies on Composer packages** in the runtime path. The plugin must run on a fresh WordPress install with no extra setup. `composer install` produces only dev tooling — `vendor/` never ships to wp.org.
- **The plugin's runtime is one PHP file.** If your change wants to split it into multiple files, raise an issue first — that's a design discussion, not a drive-by PR.
- **Quote bodies are not translated.** They are cultural artefacts (specific dub line readings) selected per-locale, not strings to be passed through `__()`. This is intentional and documented in [`.github/copilot-instructions.md`](.github/copilot-instructions.md).
- **All plugin globals are prefixed `hola_simpsons_`** (lowercase) or `HolaSimpsons` (PascalCase if you ever introduce a class). Enforced by PHPCS.

## Versioning

We follow [Semantic Versioning](https://semver.org/) for the plugin's public version (`MAJOR.MINOR.PATCH`):

- **PATCH** (1.3.2 → 1.3.3): bug fixes only, no behavior change beyond the fix itself.
- **MINOR** (1.3.x → 1.4.0): new user-visible functionality, backwards-compatible.
- **MAJOR** (1.x → 2.0): backwards-incompatible changes (rare).

Repository-only changes (this CONTRIBUTING.md, CI workflows, dev tooling, etc.) **do not** trigger a version bump — they are excluded from the wp.org deploy via [`.distignore`](.distignore) and are invisible to end users.

### `-dev` suffix on `main`

The `Version:` header in `hola-simpsons.php` carries a **`-dev` suffix on `main`** to signal that the working tree is in active development and not a tagged release.

| Where | Looks like | Means |
|---|---|---|
| `main` between releases | `Version: 1.4.0-dev` | "Working towards 1.4.0; this is NOT a release" |
| Final release commit | `Version: 1.4.0` | "This commit IS the 1.4.0 release; tag it" |
| Tag (e.g. `1.4.0`) | snapshot of the release commit | What ends up at wp.org and on user sites |
| `main` after release | `Version: 1.5.0-dev` | "Now working towards 1.5.0" |

The `Stable tag:` in `readme.txt` does NOT carry the suffix — it always holds the **last published release version**.

Concretely:

- Open a PR that adds a feature: leave `Version: 1.4.0-dev` alone.
- When ready to release: in a final "release prep" PR, drop the `-dev` suffix, update `Stable tag:`, and add the changelog entry.
- Push the tag `1.4.0` after merge — the deploy workflow handles wp.org.
- In a follow-up PR, bump `Version: 1.5.0-dev` on `main`.

Accepted pre-release suffixes are `-dev`, `-alpha`, `-beta`, `-rc` (optionally followed by `.N`).

## Releasing (maintainers only)

See [`docs/release.md`](docs/release.md) for the full release flow.

## AI-assisted contributions

If you use Copilot, Claude, GPT, Cursor, or any other AI tool to help write code, read [`docs/ai-policy.md`](docs/ai-policy.md) before opening a PR. The summary: use any tool you want, but you sign the commit and you own the code — every line, every test, every behaviour.

## License

By contributing, you agree that your contributions will be licensed under the [GPL-2.0-or-later](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html).
