<?php

declare(strict_types=1);

namespace Shared\Domain;

use Assert\Assertion;
use DateTimeImmutable as NativeDateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;

final readonly class DateTimeImmutable
{
    private const string DATE_FORMAT = 'Y-m-d\TH:i:s.u';

    public string $dateTime;

    public function __construct(
        string $dateTime
    ) {
        Assertion::date($dateTime, self::DATE_FORMAT);

        $this->dateTime = $dateTime;
    }

    public static function now(): self
    {
        $date = new NativeDateTimeImmutable('now', new DateTimeZone('UTC'));

        return new self($date->format(self::DATE_FORMAT));
    }

    public static function fromFormat(string $format, $datetime): self
    {
        $date = NativeDateTimeImmutable::createFromFormat($format, $datetime, new DateTimeZone('UTC'));

        if ($date === false) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid datetime format "%s" for "%s"',
                    $format,
                    $datetime
                )
            );
        }

        return new self($date->format(self::DATE_FORMAT));
    }

    public function format(string $format): string
    {
        $date = NativeDateTimeImmutable::createFromFormat(self::DATE_FORMAT, $this->dateTime);

        return $date->format($format);
    }

    public function equals(DateTimeImmutable $dateTime): bool
    {
        return $this->dateTime === $dateTime->dateTime;
    }
}
