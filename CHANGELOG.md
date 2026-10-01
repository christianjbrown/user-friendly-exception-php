# Changelog

All notable changes to this package are recorded here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the package uses
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-10-01

First stable release.

### Added

- `UserFriendlyException`, a `RuntimeException` whose message is safe to show to end users.
- `UserFriendlyExceptionInterface`, so callers can catch these exceptions without depending on the
  concrete class.

[Unreleased]: https://github.com/christianjbrown/user-friendly-exception-php/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/christianjbrown/user-friendly-exception-php/releases/tag/v1.0.0
