<?php

namespace Shared\Tests\Stub\Domain\ReadModel\Factory;

use Shared\ReadModel\AbstractProjector;
use Shared\Tests\InMemoryCollector;
use Shared\Tests\Stub\Domain\Event\DomainEventStub;

readonly class AggregateRootStubProjectionFactory extends AbstractProjector
{
    public function __construct(
        private InMemoryCollector $collector
    ) {
    }

    protected function applyDomainEventStub(DomainEventStub $event): void
    {
        $this->collector->collect($event);
    }
}