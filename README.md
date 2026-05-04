# Hola Simpsons

> A small WordPress plugin that prints a random Simpsons quote in the admin area, in the user's locale.

[![License: GPL v2+](https://img.shields.io/badge/license-GPL--2.0--or--later-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html)

## What is this?

Hola Simpsons shows a random quote from "The Simpsons" at the top of every WordPress admin page, in the spirit of the classic *Hello Dolly* plugin that ships with WordPress core. The quote rotates on every page load.

It comes with curated quote sets in five locales:

| Set | Locale code | Used for |
|-----|-------------|----------|
| LATAM Spanish (default) | `es` | `es`, `es_AR`, `es_MX`, and any unmatched locale |
| Original English | `en_US` | `en_US`, `en_GB`, `en_AU`, … |
| European Spanish | `es_ES` | `es_ES` |
| Brazilian Portuguese | `pt_BR` | `pt_BR`, `pt_PT` |
| Italian | `it_IT` | `it`, `it_IT` |

The plugin reads the user's WordPress locale via `get_user_locale()` and routes to the closest available set, falling back through the language family before defaulting to LATAM Spanish.

## For end users

If you just want to **install and use** the plugin on your WordPress site, get it from the official directory:

[wordpress.org/plugins/hola-simpsons](https://wordpress.org/plugins/hola-simpsons/)

User-facing documentation (features, installation, FAQ) lives in [`readme.txt`](readme.txt) — that's the version rendered on the wp.org plugin page.

## For developers

This README and the rest of this repository are aimed at developers who want to **contribute, fork, or run the plugin from source**.

## Quick start (developers)

```bash
git clone https://github.com/soydiloreto/hola-simpsons.git
cd hola-simpsons
make install     # composer install — populate vendor/
make env         # boots wp-env at http://localhost:8888
```

When it finishes, open <http://localhost:8888>. Log in with `admin` / `password`. The plugin is already mounted at `wp-content/plugins/hola-simpsons/` — activate it from the **Plugins** screen and visit any admin page to see a quote.

`make help` lists every available target. For the full setup walkthrough, the day-to-day commands, the Docker plumbing, and the `wp-env` configuration, see [`docs/development.md`](docs/development.md).

## Repository layout

| Path | What it contains |
|------|------------------|
| `hola-simpsons.php` | Entire plugin — plugin header, four functions, two `add_action` calls. |
| `readme.txt` | wp.org plugin page content (description, FAQ, changelog). |
| `.wordpress-org/` | wp.org listing visuals — banner, icon, screenshots. Uploaded by CI to the SVN `assets/` directory, **not** to the published plugin zip. |
| `tests/` | PHPUnit unit tests. Currently covers the locale-picking logic. |
| `docs/` | Developer documentation (this is the index). |
| `.github/workflows/` | CI/CD: deploy to wp.org SVN on tag push, plus PR checks. |
| `.distignore` | List of paths excluded from the wp.org deploy (this README, dev tooling, etc. live in GitHub but are never shipped to wp.org). |

## Documentation

For developers working on the plugin itself:

- [`CONTRIBUTING.md`](CONTRIBUTING.md) — branch naming, PR workflow, commit conventions, coding rules.
- [`docs/development.md`](docs/development.md) — local dev setup (`wp-env`, Docker, Make targets).
- [`docs/testing-and-quality.md`](docs/testing-and-quality.md) — PHPUnit, PHPCS, PHPStan, Psalm, i18n. What each layer enforces and how to run it.
- [`docs/ai-tooling.md`](docs/ai-tooling.md) — what AI tooling the project uses (Copilot Code Review and friends), what it costs, and what it's configured to enforce.
- [`docs/ai-policy.md`](docs/ai-policy.md) — rules for contributors using AI agents to author code.
- [`docs/release.md`](docs/release.md) — version bump flow, the `-dev` suffix convention, the wp.org SVN deploy.

## Contributing

Contributions are welcome — bug reports, new quote suggestions, additional locale sets, and pull requests. See [`CONTRIBUTING.md`](CONTRIBUTING.md) to get started.

## Reporting security issues

Please do not open public issues for security vulnerabilities. See [SECURITY.md](SECURITY.md) for the private reporting process via GitHub Security Advisories.

## About

This plugin is **free and open-source software** under the GPL-2.0-or-later licence. It was created and is currently maintained by **Pablo Diloreto** ([@soydiloreto](https://github.com/soydiloreto)). It started as a Spanish-language counterpart to *Hello Dolly* and has grown over the years to include curated quote sets for several locales.

Contributions, issues, and forks are all welcome.

## License

GPL-2.0-or-later. See the [WordPress GPL page](https://wordpress.org/about/license/).
