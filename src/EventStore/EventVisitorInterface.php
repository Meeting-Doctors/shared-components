<?php

declare(strict_types=1);

namespace Shared\EventStore;

use Shared\Domain\DomainEvent;

interface EventVisitorInterface
{
    public function doWithEvent(DomainEvent $event): void;
}
