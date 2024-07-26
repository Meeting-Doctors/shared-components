<?php

declare(strict_types=1);

namespace Shared\Domain;

final readonly class Playhead
{
    public int $value;

    public function __construct(
        int $value
    ) {
        $this->ensureValueGreaterThanZero($value);
        $this->value = $value;
    }

    private function ensureValueGreaterThanZero(int $value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Playhead value must be greater than 0');
        }
    }

    public static function zero(): Playhead
    {
        return new Playhead(0);
    }

    public function next(): Playhead
    {
        return new Playhead($this->value + 1);
    }

    public function equals(Playhead $playhead): bool
    {
        return $playhead->value === $this->value;
    }
}
