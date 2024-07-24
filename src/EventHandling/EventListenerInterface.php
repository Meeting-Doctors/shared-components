<?php

declare(strict_types=1);

namespace Shared\EventHandling;

use Shared\Domain\DomainEvent;

interface EventListenerInterface
{
    /**
     * @throws \Throwable
     */
    public function handle(DomainEvent $event): void;
}
