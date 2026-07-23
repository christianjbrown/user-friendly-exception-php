# CLAUDE.md

Guidance for working in this repository. Match the existing conventions exactly — this codebase is
tiny, uniform, and highly opinionated, so new code should be indistinguishable from what's here.

## What this is

An **extremely simple** PHP 8.5+ library providing a single reusable exception,
`UserFriendlyException`. Throwing it signals that the exception `$message` is safe and clear enough
to be shown directly to an end user (e.g. surfaced in an HTTP response), as opposed to a technical
exception whose message must not leak. There is no behavior beyond that contract: the class is an
empty `final` subclass of `RuntimeException` implementing the marker interface
`UserFriendlyExceptionInterface` (which extends `Throwable`), so callers can
`catch (UserFriendlyExceptionInterface)` and hand `$e->getMessage()` straight to the user. This
library is standalone — it is not a dependency of the sibling API-client libraries.

## Commands

Binaries install into `bin/` (Composer `bin-dir`), not `vendor/bin/`. Both `bin/` and `vendor/` are
gitignored and Composer-installed, so run `composer install` first. Style tooling comes from the
`christianjbrown/php-code-quality-scripts` dev dependency (php-cs-fixer + PHP_CodeSniffer, **Symfony2
coding standard**); the `bin/php-cs*` scripts are thin wrappers over it. Installing it needs
SSH/`COMPOSER_AUTH` access to the private repo.

| Task | Command |
| --- | --- |
| Run tests + coverage (opens HTML report) | `composer test` |
| Run tests, no coverage | `php -d memory_limit=-1 ./bin/phpunit --no-coverage` |
| Static analysis (PHPStan level max) | `composer stan` |
| Check code style | `composer check-style` |
| Auto-fix code style | `composer fix-style` |
| Check / fix style on git diff only | `composer check-style-diff` / `composer fix-style-diff` |

Always run `composer fix-style` first (php-cs-fixer auto-fixes what it can), then `composer
check-style` to surface remaining violations that must be fixed by hand, then `composer stan`, then
`composer test` before finishing. CI (`.github/workflows/ci.yml`) runs the same gates — style →
PHPStan → PHPUnit-with-coverage — on push/PR to `main`, on PHP 8.5.

## Architecture

Everything lives under `ChristianBrown\UserFriendlyException\` (`src/`), mirrored 1:1 under
`ChristianBrown\UserFriendlyException\Tests\` (`tests/`). Two files, no subfolders:

- **`UserFriendlyExceptionInterface`** — `interface UserFriendlyExceptionInterface extends Throwable`,
  empty body. The type consumers catch.
- **`UserFriendlyException`** — `final class UserFriendlyException extends RuntimeException implements
  UserFriendlyExceptionInterface`, empty body. All behavior (message/code/previous) is inherited from
  `RuntimeException`.

## Conventions (follow all of these)

- `declare(strict_types=1);` on every file, immediately after `<?php`.
- **Every concrete class is `final` and implements a matching `...Interface`** in the same namespace.
- **A method that does not use `$this` must be `static`** (called via `self::`) — a stateless helper is
  static. Enforced for private methods by the shared `RequireStaticPrivateMethodRule` PHPStan rule (via
  `php-code-quality-scripts`' `config/phpstan.neon`); interface/override methods stay instance.
- No file-level doc/license headers — files go straight from `<?php` to `declare` to `namespace`.
- Keep it minimal: the exception carries no custom constructor, properties, or constants. If new
  behavior is ever genuinely needed, prefer the `RuntimeException` inheritance already in place.

## Testing

The `phpunit.xml` config is strict (`requireCoverageMetadata`, `beStrictAboutCoverageMetadata`,
`failOnRisky`, `failOnWarning`, path coverage), so every test needs coverage metadata.

- **Keep coverage at 100%** (lines, paths, methods, branches). Always run `composer test` and check
  the report (text summary to stdout + HTML at `.phpunit.cache/code-coverage-html/index.html`) before
  finishing.
- **Every test class needs a `#[CoversClass(...)]` attribute.** Use PHPUnit 12 **attributes, not
  annotations** (`#[CoversClass]`, `#[DataProvider]`, `#[TestWith]`).
- Tests are `final class XTest extends TestCase`, methods named `test<Scenario>`, asserting statically
  (`self::assertSame`, `self::assertInstanceOf`). See `tests/UserFriendlyExceptionTest.php`.
