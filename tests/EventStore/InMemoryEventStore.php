<?php

declare(strict_types=1);

namespace Shared\Tests\EventStore;

use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;
use Shared\EventStore\DomainEventStreamNotFoundException;
use Shared\EventStore\EventStoreInterface;
use Shared\EventStore\EventStoreManagerInterface;
use Shared\EventStore\EventVisitorInterface;

final class InMemoryEventStore implements EventStoreInterface, EventStoreManagerInterface
{
    private array $data = [];

    #[\Override]
    public function load(Uuid $id, ?int $playhead = null): DomainEventStream
    {
        if (!isset($this->data[$id->uuid])) {
            throw DomainEventStreamNotFoundException::new($id, $playhead);
        }

        return new DomainEventStream(...$this->data[$id->uuid]);
    }

    #[\Override]
    public function append(DomainEventStream $stream): void
    {
        foreach ($stream->events as $event) {
            $this->data[$event->aggregateId()->uuid][$event->playhead()->value] = $event;
        }
    }

    #[\Override]
    public function visitEvents(Uuid $aggregateId, EventVisitorInterface $eventVisitor, ?int $playhead = null): void
    {
        $events = $this->data[$aggregateId->uuid];

        foreach ($events as $event) {
            $eventVisitor->doWithEvent($event);
        }
    }
}
