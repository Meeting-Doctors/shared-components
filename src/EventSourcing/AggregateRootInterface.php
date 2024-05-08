<?php

declare(strict_types=1);

namespace Shared\EventSourcing;

use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;

interface AggregateRootInterface
{
    public function uncommittedEvents(): DomainEventStream;

    public function id(): Uuid;
}
