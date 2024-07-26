<?php

declare(strict_types=1);

namespace Shared\ReadModel;

use Shared\Domain\Uuid;

final class ReadModelNotFoundException extends \RuntimeException
{
    public static function new(Uuid $id, string $class): self
    {
        return new self(
            sprintf(
                'ReadModel %s with id "%s" could not be found',
                $class,
                $id->uuid
            )
        );
    }
}
