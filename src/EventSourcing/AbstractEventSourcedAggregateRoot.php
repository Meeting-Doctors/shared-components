<?php

declare(strict_types=1);

namespace Shared\EventSourcing;

use Shared\Domain\DomainEvent;
use Shared\Domain\DomainEventStream;
use Shared\Domain\Playhead;

abstract class AbstractEventSourcedAggregateRoot implements AggregateRootInterface
{
    /** @var DomainEvent[] */
    private array $uncommittedEvents;
    private Playhead $playhead;

    public function __construct()
    {
        $this->uncommittedEvents = [];
        $this->playhead = Playhead::zero();
    }

    final public function initialize(DomainEventStream $stream): void
    {
        foreach ($stream->events as $event) {
            $this->apply($event);
        }
    }

    final public function playhead(): Playhead
    {
        return $this->playhead;
    }

    #[\Override]
    final public function uncommittedEvents(): DomainEventStream
    {
        $stream = new DomainEventStream(...$this->uncommittedEvents);

        $this->uncommittedEvents = [];

        return $stream;
    }

    protected function recordThat(DomainEvent $event): void
    {
        $event = $event->withPlayhead($this->playhead->next());

        $this->apply($event);

        $this->uncommittedEvents[] = $event;
    }

    private function apply(DomainEvent $event): void
    {
        $nextPlayhead = $event->playhead();

        $this->assertInvalidNextPlayhead($nextPlayhead);

        $this->callApplyMethod($event);

        $this->playhead = $nextPlayhead;
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

    private function assertInvalidNextPlayhead(Playhead $playhead): void
    {
        $aggregateNextPlayhead = $this->playhead->next();

        if (!$playhead->equals($aggregateNextPlayhead)) {
            throw new \RuntimeException(sprintf('Invalid new Playhead %d. Expected %d', $playhead->next()->value, $aggregateNextPlayhead->value));
        }
    }
}
