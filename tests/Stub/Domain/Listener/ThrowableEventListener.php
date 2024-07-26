<?php

declare(strict_types=1);

namespace Shared\Tests\Stub\Domain\Listener;

use Shared\Domain\DomainEvent;
use Shared\EventHandling\EventListenerInterface;

class ThrowableEventListener implements EventListenerInterface
{
    #[\Override]
    public function handle(DomainEvent $event): void
    {
        throw new \Exception();
    }
}
