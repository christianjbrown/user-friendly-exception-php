<?php

declare(strict_types=1);

namespace ChristianBrown\UserFriendlyException\Tests;

use ChristianBrown\UserFriendlyException\UserFriendlyException;
use ChristianBrown\UserFriendlyException\UserFriendlyExceptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(UserFriendlyException::class)]
final class UserFriendlyExceptionTest extends TestCase
{
    public function testDefaultsWhenOnlyMessageGiven(): void
    {
        $exception = new UserFriendlyException('test-message');

        self::assertSame(0, $exception->getCode());
        self::assertNull($exception->getPrevious());
    }

    public function testExposesMessageCodeAndPrevious(): void
    {
        $previous = new RuntimeException('technical-detail');
        $exception = new UserFriendlyException('test-message', 503, $previous);

        self::assertSame('test-message', $exception->getMessage());
        self::assertSame(503, $exception->getCode());
        self::assertSame($previous, $exception->getPrevious());
    }

    public function testIsThrowableUserFriendlyRuntimeException(): void
    {
        $exception = new UserFriendlyException('test-message');

        self::assertInstanceOf(UserFriendlyExceptionInterface::class, $exception);
        self::assertInstanceOf(RuntimeException::class, $exception);
    }
}
