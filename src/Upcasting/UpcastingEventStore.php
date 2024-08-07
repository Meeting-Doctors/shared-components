<?php

declare(strict_types=1);

namespace Shared\Upcasting;

use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;
use Shared\EventStore\EventStoreInterface;

final readonly class UpcastingEventStore implements EventStoreInterface
{
    public function __construct(
        private EventStoreInterface $eventStore,
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

    #[\Override]
    public function append(DomainEventStream $stream): void
    {
        $this->eventStore->append($stream);
    }

    private function upcast(DomainEventStream $stream): \Generator
    {
        foreach ($stream->events as $event) {
            if ($this->upcaster->supports($event)) {
                yield $this->upcaster->upcast($event);
            }
        }
    }
}
