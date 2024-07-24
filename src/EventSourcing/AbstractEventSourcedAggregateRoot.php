<?php

declare(strict_types=1);

namespace Shared\EventSourcing;

use Override;
use RuntimeException;
use Shared\Domain\DomainEvent;
use Shared\Domain\DomainEventStream;
use Shared\Domain\PlayHead;

abstract class AbstractEventSourcedAggregateRoot implements AggregateRootInterface
{
    /** @var DomainEvent[] */
    private array $uncommittedEvents;
    private PlayHead $playHead;

    public function __construct()
    {
        $this->uncommittedEvents = [];
        $this->playHead = PlayHead::zero();
    }

    final public function initialize(DomainEventStream $stream): void
    {
        foreach ($stream->events as $event) {
            $this->apply($event);
        }
    }

    final public function playHead(): PlayHead
    {
        return $this->playHead;
    }

    #[Override]
    final public function uncommittedEvents(): DomainEventStream
    {
        $stream = new DomainEventStream(...$this->uncommittedEvents);

        $this->uncommittedEvents = [];

        return $stream;
    }

    protected function recordThat(DomainEvent $event): void
    {
        $event = $event->withPlayHead($this->playHead->next());

        $this->apply($event);

        $this->uncommittedEvents[] = $event;
    }

    private function apply(DomainEvent $event): void
    {
        $nextPlayHead = $event->playHead();

        $this->assertInvalidNextPlayHead($nextPlayHead);

        $this->callApplyMethod($event);

        $this->playHead = $nextPlayHead;
    }

    private function callApplyMethod(DomainEvent $event): void
    {
        $method = $this->applyMethod($event);

        if (!method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    private function applyMethod(DomainEvent $event): string
    {
        $fqcn = explode('\\', $event::class);

        return sprintf('apply%s', end($fqcn));
    }

    private function assertInvalidNextPlayHead(PlayHead $playHead): void
    {
        $aggregateNextPlayHead = $this->playHead->next();

        if (!$playHead->equals($aggregateNextPlayHead)) {
            throw new RuntimeException(
                sprintf(
                    'Invalid new PlayHead %d. Expected %d',
                    $playHead->next()->value,
                    $aggregateNextPlayHead->value
                )
            );
        }
    }
}
