# User-Friendly Exception

[![CI](https://github.com/christianjbrown/user-friendly-exception-php/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/user-friendly-exception-php/actions/workflows/ci.yml) [![Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen)](https://github.com/christianjbrown/user-friendly-exception-php/actions/workflows/ci.yml) [![Packagist](https://img.shields.io/packagist/v/christianjbrown/user-friendly-exception)](https://packagist.org/packages/christianjbrown/user-friendly-exception) [![License](https://img.shields.io/packagist/l/christianjbrown/user-friendly-exception)](https://github.com/christianjbrown/user-friendly-exception-php/blob/main/LICENSE) [![PHP](https://img.shields.io/packagist/dependency-v/christianjbrown/user-friendly-exception/php)](https://packagist.org/packages/christianjbrown/user-friendly-exception)

This is an **extremely simple** PHP library for a reusable `UserFriendlyException` class.

Using `UserFriendlyException` indicates that the `$message` passed is safe to and clear enough to be bubbled up to the end user.

## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.5 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.



## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/user-friendly-exception
```


## :computer: Usage

Throwing the exception after catching a non-user-friendly exception.

```php
use ChristianBrown\UserFriendlyException\UserFriendlyException;
use RuntimeException;

try {
  // ...
  // Technical issue here
  // ...
} catch (RuntimeException $e) {
  throw new UserFriendlyException('We encountered a technical issue. Please try again later', 0, $e);
}
```

Later passing the contents of `UserFriendlyException` directly to the end users

```php
use ChristianBrown\UserFriendlyException\UserFriendlyExceptionInterface;
use Throwable;

$app = new Application();
try {
  $responseText = $app->run();
  $response = new Response($responseText, 200);
} catch (UserFriendlyExceptionInterface $e) {
  $response = new Response($e->getMessage(), $e->getCode() ?: 500);
} catch (Throwable $e) {
  $response = new Response('An unknown error occurred, try again later', 500);
}

return $response;
```


## :memo: Changelog

Notable changes in each release are listed in [CHANGELOG.md](CHANGELOG.md).



## :page_facing_up: License

Released under the [MIT License](LICENSE).

