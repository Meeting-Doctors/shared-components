<?php

declare(strict_types=1);

namespace Shared\ReadModel;

use Shared\Domain\Uuid;

final class ReadModelNotFoundException extends \RuntimeException
{
    public static function new(Uuid $id): self
    {
        return new self(
            sprintf(
                'ReadModel with id "%s" could not be found',
                $id->uuid
            )
        );
    }
}
