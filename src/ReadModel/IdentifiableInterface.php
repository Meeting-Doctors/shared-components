<?php

declare(strict_types=1);

namespace Shared\ReadModel;

use Shared\Domain\Uuid;

interface IdentifiableInterface
{
    public function id(): Uuid;
}
