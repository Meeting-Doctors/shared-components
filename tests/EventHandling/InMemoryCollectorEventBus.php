<?php

declare(strict_types=1);

namespace Shared\Tests\EventHandling;

use Shared\Domain\DomainEvent;
use Shared\Domain\DomainEventStream;
use Shared\EventHandling\EventBusInterface;

final class InMemoryCollectorEventBus implements EventBusInterface
{
    /** @var DomainEvent[] */
    private array $events = [];

    #[\Override]
    public function publish(DomainEventStream $stream): void
    {
        foreach ($stream->events as $event) {
            $this->events[] = $event;
        }
    }

    public function events(): array
    {
        return $this->events;
    }
}
