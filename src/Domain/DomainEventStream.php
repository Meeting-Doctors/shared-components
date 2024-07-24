<?php

declare(strict_types=1);

namespace Shared\Domain;

final readonly class DomainEventStream
{
    /** @var DomainEvent[] */
    public array $events;

    public function __construct(
        DomainEvent ...$events
    ) {
        $this->events = $events;
    }
}
