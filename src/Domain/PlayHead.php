<?php

declare(strict_types=1);

namespace Shared\Domain;

final readonly class PlayHead
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
            throw new \InvalidArgumentException('PlayHead value must be greater than 0');
        }
    }

    public static function zero(): PlayHead
    {
        return new PlayHead(0);
    }

    public function next(): PlayHead
    {
        return new PlayHead($this->value + 1);
    }

    public function equals(PlayHead $playHead): bool
    {
        return $playHead->value === $this->value;
    }
}
