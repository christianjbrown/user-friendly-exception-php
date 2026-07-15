# User-Friendly Exception

[![CI](https://github.com/christianjbrown/php-user-friendly-exception-lib/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/php-user-friendly-exception-lib/actions/workflows/ci.yml)

This is an **extremely simple** PHP library for a reusable `UserFriendlyException` class.

Using `UserFriendlyException` indicates that the `$message` passed is safe to and clear enough to be bubbled up to the end user.

## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.3 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.



## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/php-user-friendly-exception-lib
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


## :page_facing_up: License

Released under the [MIT License](LICENSE).

