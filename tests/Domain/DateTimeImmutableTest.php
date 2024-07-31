<?php

declare(strict_types=1);

namespace Shared\Tests\Domain;

use Assert\AssertionFailedException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Shared\Domain\DateTimeImmutable;

final class DateTimeImmutableTest extends TestCase
{
    public function test_must_throw_assertion_failed_exception(): void
    {
        self::expectException(InvalidArgumentException::class);

        DateTimeImmutable::fromFormat('u', '');
    }

    public function test_must_compare_two_instances(): void
    {
        $some = DateTimeImmutable::fromFormat(DATE_ATOM, '2024-01-01T00:00:00+00:00');
        $another = DateTimeImmutable::fromFormat(DATE_ATOM, '2024-01-01T00:00:00+01:00');

        self::assertFalse($some->equals($another));
    }
}
