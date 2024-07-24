<?php

declare(strict_types=1);

namespace Shared\EventSourcing;

use Shared\Domain\DomainEvent;

interface EventSourcedEntityInterface
{
    public function handleRecursively(DomainEvent $event): void;

    /**
     * @throws AggregateRootAlreadyExistsException
     */
    public function setAggregateRoot(AbstractEventSourcedAggregateRoot $aggregateRoot): void;
}
