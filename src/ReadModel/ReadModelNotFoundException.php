<?php

declare(strict_types=1);

namespace Shared\ReadModel;

use Shared\Domain\Uuid;
use Shared\Exception\NotFoundException;

final class ReadModelNotFoundException extends NotFoundException
{
    public static function new(Uuid $id, string $class): self
    {
        return new self(
            sprintf(
                'ReadModel "%s" with id "%s" could not be found',
                $class,
                $id->uuid
            )
        );
    }
}
