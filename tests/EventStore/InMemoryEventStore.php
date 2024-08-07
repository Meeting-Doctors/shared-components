<?php

declare(strict_types=1);

namespace Shared\Tests\EventStore;

use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;
use Shared\EventStore\DomainEventStreamNotFoundException;
use Shared\EventStore\EventStoreInterface;

final class InMemoryEventStore implements EventStoreInterface
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
}
