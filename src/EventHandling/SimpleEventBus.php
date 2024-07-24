<?php

declare(strict_types=1);

namespace Shared\EventHandling;

use Shared\Domain\DomainEvent;
use Shared\Domain\DomainEventStream;

final class SimpleEventBus implements EventBusInterface
{
    /** @var EventListenerInterface[] */
    private array $eventListeners = [];

    /** @var DomainEvent[] */
    private array $queue = [];

    private bool $isPublishing = false;

    #[\Override]
    public function subscribe(EventListenerInterface $eventListener): void
    {
        $this->eventListeners[] = $eventListener;
    }

    #[\Override]
    public function publish(DomainEventStream $stream): void
    {
        foreach ($stream->events as $event) {
            $this->queue[] = $event;
        }

        if (!$this->isPublishing) {
            $this->isPublishing = true;

            try {
                while ($event = array_shift($this->queue)) {
                    $this->handle($event);
                }
            } finally {
                $this->isPublishing = false;
            }
        }
    }

    private function handle(DomainEvent $event): void
    {
        foreach ($this->eventListeners as $eventListener) {
            try {
                $eventListener->handle($event);
            } catch (\Throwable $e) {
                throw EventBusException::new($e);
            }
        }
    }
}
