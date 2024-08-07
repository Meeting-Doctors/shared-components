<?php

declare(strict_types=1);

namespace Shared\EventStore;

use Shared\Domain\Uuid;

class EventStoreManager implements EventStoreManagerInterface
{
    public function __construct(private EventStoreInterface $eventStore)
    {
    }

    #[\Override]
    public function visitEvents(Uuid $aggregateId, EventVisitorInterface $eventVisitor, ?int $playhead = null): void
    {
        $stream = $this->eventStore->load($aggregateId, $playhead);

        foreach ($stream->events as $event) {
            $eventVisitor->doWithEvent($event);
        }
    }
}
