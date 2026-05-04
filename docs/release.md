# Release process

For maintainers. End users get the plugin from [wordpress.org/plugins/hola-simpsons](https://wordpress.org/plugins/hola-simpsons/) — they don't need to read this document.

## Versioning

We follow [Semantic Versioning](https://semver.org/) for the plugin's public version (`MAJOR.MINOR.PATCH`):

| Bump | When |
| --- | --- |
| **PATCH** (1.3.2 → 1.3.3) | Bug fixes only, no behaviour change beyond the fix itself. |
| **MINOR** (1.3.x → 1.4.0) | New user-visible functionality, backwards-compatible (new quote sets, new locale routing, etc.). |
| **MAJOR** (1.x → 2.0)     | Backwards-incompatible changes. Avoid unless truly necessary. |

Repository-only changes (CI, dev tooling, this `docs/` directory, …) **do not** trigger a version bump. Those files are excluded from the wp.org deploy via [`.distignore`](../.distignore) and are invisible to end users.

## The `-dev` suffix

The PHP `Version:` header in `hola-simpsons.php` carries a `-dev` suffix on `main` between releases. The `Stable tag:` in `readme.txt` does **not** — it always holds the last published release.

| State | PHP `Version:` | readme `Stable tag:` |
| --- | --- | --- |
| `main` between releases | `1.4.0-dev` | `1.3.2` (last released) |
| Release-prep PR open | `1.4.0` | `1.4.0` |
| Tag `1.4.0` pushed | snapshot of the release-prep state | |
| `main` after release | `1.5.0-dev` | `1.4.0` |

Why: a developer who clones `main` between releases sees `1.4.0-dev` and immediately knows they're not looking at the published version. Without the suffix, the same clone would show `1.4.0` indistinguishable from the actual published release.

The CI version-alignment rule strips the suffix from the PHP `Version:` header before comparing it to `Stable tag:` so this asymmetry is allowed mid-development. At tag time the suffix is gone and the two values must match exactly — `make release` runs the same check locally.

Accepted pre-release suffixes are `-dev`, `-alpha`, `-beta`, `-rc` (optionally followed by `.N`).

## Cutting a release

Once the work for the next version is merged into `main` and CI is green:

1. **Pre-flight locally.**
   ```bash
   git checkout main
   git pull
   make release        # full quality gate + version-alignment dry-run
   ```
   `make release` will fail if PHP `Version:` (after stripping `-dev`) and readme `Stable tag:` don't match. Don't push the tag if it complains.

2. **Open a release-prep PR.** Branch name: `chore/release-X.Y.Z`. The PR does two things:
   - Drops the `-dev` suffix in the `Version:` header of `hola-simpsons.php`.
   - Updates `readme.txt`: `Stable tag:` to the new version, and adds a `= X.Y.Z =` block under `== Changelog ==` summarising user-visible changes.

3. **Wait for CI to pass on the release-prep PR.** Same gates as any other PR. Notably, this is when the strict `version-alignment` step (`pr-checks.yml`) catches mismatches — `make release` should already have caught them.

4. **Merge** the release-prep PR (squash, as usual).

5. **Tag.** Bare-number, no `v` prefix:
   ```bash
   git checkout main
   git pull
   git tag X.Y.Z
   git push origin X.Y.Z
   ```

6. **The deploy workflow takes it from there.** [`.github/workflows/deploy.yml`](../.github/workflows/deploy.yml) fires on tag push; it does:
   - Strict tag-format validation (`^[0-9]+\.[0-9]+\.[0-9]+$`).
   - Strict version-alignment of both markers — PHP `Version:` and readme `Stable tag:` — against the git tag.
   - [`10up/action-wordpress-plugin-deploy@stable`](https://github.com/10up/action-wordpress-plugin-deploy) to push `/trunk` and tag `/tags/X.Y.Z` on the wp.org SVN, and to upload `.wordpress-org/` assets to the SVN `/assets/` directory.
   - Generate the GitHub release with the changelog excerpt as the body.

7. **Verify on wp.org** within ~10 minutes. The new version should appear at `https://wordpress.org/plugins/hola-simpsons/`. wp.org does not run automated rollouts — sites with auto-update enabled pick it up over the next ~12 hours via the WordPress core update check.

8. **Bump back to dev.** Open a follow-up PR `chore/bump-(X.Y.Z+1)-dev` that:
   - Sets the `Version:` header to `(next intended version)-dev`.
   - Leaves `Stable tag:` alone (it stays at the just-released `X.Y.Z`).

   Merge it. Now `main` is signposted "in development towards (next)" again.

## Required secrets

The deploy workflow needs two secrets in the repo settings:

| Secret | What it's for |
| --- | --- |
| `SVN_USERNAME` | wp.org account username (the same one used for the plugin submission). |
| `SVN_PASSWORD` | wp.org SVN-specific password (rotate from <https://wordpress.org/support/users/profile/svn-password>, **not** the regular login password). |

If either is missing or wrong the deploy step prints a clear error and exits non-zero — `main` and the tag are unaffected. Just rotate the secret and push the tag again.

## Rolling back

There is no "undo" on wp.org for a published release — once a tag is on the SVN, it's there. To roll back, ship `X.Y.Z+1` with the previous version's code. Don't try to delete the bad tag from SVN; that is more disruptive than just re-releasing.

For the GitHub side, you can delete a Release and its Git tag, but only do so if the wp.org SVN tag did *not* go out — once the SVN side has the version, the GitHub tag is the canonical historical record and shouldn't move.
