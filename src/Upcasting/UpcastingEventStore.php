<?php

declare(strict_types=1);

namespace Shared\Upcasting;

use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;
use Shared\EventStore\EventStoreInterface;
use Shared\EventStore\EventStoreManagerInterface;
use Shared\EventStore\EventVisitorInterface;

final readonly class UpcastingEventStore implements EventStoreInterface, EventStoreManagerInterface
{
    public function __construct(
        private EventStoreInterface&EventStoreManagerInterface $eventStore,
        private UpcasterInterface $upcaster
    ) {
    }

    #[\Override]
    public function load(Uuid $id, ?int $playhead = null): DomainEventStream
    {
        $stream = $this->eventStore->load($id, $playhead);
        $messages = $this->upcast($stream);

        return new DomainEventStream(...$messages);
    }

    private function upcast(DomainEventStream $stream): \Generator
    {
        foreach ($stream->events as $event) {
            if ($this->upcaster->supports($event)) {
                yield $this->upcaster->upcast($event);
            }
        }
    }

    #[\Override]
    public function append(DomainEventStream $stream): void
    {
        $this->eventStore->append($stream);
    }

    #[\Override]
    public function visitEvents(Uuid $aggregateId, EventVisitorInterface $eventVisitor, ?int $playhead = null): void
    {
        $this->eventStore->visitEvents($aggregateId, $eventVisitor, $playhead);
    }
}
