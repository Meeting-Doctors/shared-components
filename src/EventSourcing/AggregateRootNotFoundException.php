<?php

declare(strict_types=1);

namespace Shared\EventSourcing;

use Shared\Domain\Uuid;
use Shared\Exception\NotFoundException;

final class AggregateRootNotFoundException extends NotFoundException
{
    public static function new(Uuid $id, string $class): self
    {
        return new self(sprintf('AggregateRoot "%s" with id "%s" could not be found.', $class, $id->uuid));
    }
}
