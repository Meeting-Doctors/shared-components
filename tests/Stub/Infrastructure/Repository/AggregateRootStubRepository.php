<?php

namespace Shared\Tests\Stub\Infrastructure\Repository;

use Shared\Domain\Uuid;
use Shared\EventSourcing\AbstractEventSourcingRepository;
use Shared\Tests\Stub\Domain\AggregateRootStub;

readonly class AggregateRootStubRepository extends AbstractEventSourcingRepository
{
    public function get(Uuid $id, ?int $playhead = null): AggregateRootStub
    {
        return $this->load($id, $playhead);
    }

    public function store(AggregateRootStub $aggregateRoot): void
    {
        $this->save($aggregateRoot);
    }
}