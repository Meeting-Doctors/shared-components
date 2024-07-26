<?php

declare(strict_types=1);

namespace Shared\Tests\Stub\Domain\Listener;

use Shared\Domain\DomainEvent;
use Shared\EventHandling\EventListenerInterface;
use Shared\Tests\InMemoryCollector;

class EventListenerStub implements EventListenerInterface
{
    public function __construct(
        private InMemoryCollector $collector
    ) {
    }

    #[\Override]
    public function handle(DomainEvent $event): void
    {
        $this->collector->collect($event);
    }
}
