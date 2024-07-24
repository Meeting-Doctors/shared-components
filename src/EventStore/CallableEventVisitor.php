<?php

declare(strict_types=1);

namespace Shared\EventStore;

use Shared\Domain\DomainEvent;

final readonly class CallableEventVisitor implements EventVisitorInterface
{
    public function __construct(
        private \Closure $callable
    ) {
    }

    #[\Override]
    public function doWithEvent(DomainEvent $event): void
    {
        call_user_func($this->callable, $event);
    }
}
