<?php

declare(strict_types=1);

namespace Shared\Tests\EventStore;

use Shared\Criteria;
use Shared\Domain\DomainEvent;
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
            $this->data[$event->aggregateId()->uuid][$event->playHead()->value] = $event;
        }
    }

    #[\Override]
    public function visitEvents(Criteria\AndX|Criteria\OrX $criteria, EventVisitorInterface $eventVisitor): void
    {
        /** @var Criteria\Expr\AndX $andX */
        $andX = $criteria->expr();
        /** @var Criteria\Expr\Comparison $expr */
        $expr = $andX->expressions[0];
        /** @var Uuid $id */
        $id = $expr->value;
        /** @var DomainEvent[] $stream */
        $stream = $this->data[$id->uuid];

        foreach ($stream as $message) {
            $eventVisitor->doWithEvent($message);
        }
    }
}
