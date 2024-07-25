<?php

declare(strict_types=1);

namespace Shared\EventHandling;

use Shared\Domain\DomainEventStream;

interface EventBusInterface
{
    /**
     * @throws EventBusException
     */
    public function publish(DomainEventStream $stream): void;
}
