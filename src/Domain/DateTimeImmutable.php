<?php

declare(strict_types=1);

namespace Shared\Domain;

use Assert\Assertion;

use DateTimeImmutable as NativeDateTimeImmutable;
use InvalidArgumentException;

final readonly class DateTimeImmutable
{
    private const string DATE_FORMAT = 'U';

    private int $timestamp;

    private function __construct(
        int $timestamp
    ) {
        $this->timestamp = $timestamp;
    }

    public static function now(): self
    {
        $date = new NativeDateTimeImmutable();

        return new self($date->getTimestamp());
    }

    public static function fromFormat(string $format, $datetime): self
    {
        $date = NativeDateTimeImmutable::createFromFormat($format, $datetime);

        if ($date === false) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid datetime format "%s" for "%s"',
                    $format,
                    $datetime
                )
            );
        }

        return new self($date->getTimestamp());
    }

    public function timestamp(): int
    {
        return $this->timestamp;
    }

    public function format(string $format): string
    {
        $date = NativeDateTimeImmutable::createFromFormat(self::DATE_FORMAT, (string) $this->timestamp);

        return $date->format($format);
    }

    public function equals(DateTimeImmutable $dateTime): bool
    {
        return $this->timestamp() === $dateTime->timestamp();
    }

    public function gt(DateTimeImmutable $dateTime): bool
    {
        return $this->timestamp > $dateTime->timestamp;
    }
}
