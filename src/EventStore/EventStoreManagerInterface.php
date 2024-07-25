<?php

declare(strict_types=1);

namespace Shared\EventStore;

use Shared\Domain\Uuid;

interface EventStoreManagerInterface
{
    public function visitEvents(Uuid $aggregateId, EventVisitorInterface $eventVisitor, ?int $playhead = null): void;
}
