<?php

namespace Shared\Tests\Stub\Domain;

use Shared\Domain\Uuid;
use Shared\EventSourcing\AbstractEventSourcedAggregateRoot;
use Shared\Tests\Stub\Domain\Event\AggregateRootStubTotalWasChanged;
use Shared\Tests\Stub\Domain\Event\AggregateRootStubTotalWasChangedV1;
use Shared\Tests\Stub\Domain\Event\AggregateRootStubWasCreated;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedPayload;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedV2Payload;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubWasCreatedPayload;

class AggregateRootStub extends AbstractEventSourcedAggregateRoot
{
    private Uuid $id;
    private int $total;

    public static function create(
        Uuid $id,
        int $total = 0
    ): self {
        $aggregateRoot = new self();

        $aggregateRoot->recordThat(AggregateRootStubWasCreated::occur(
            $id,
            new AggregateRootStubWasCreatedPayload($total)
        ));

        return $aggregateRoot;
    }

    #[\Override]
    public function id(): Uuid
    {
        return $this->id;
    }

    public function changeTotal(int $total): void
    {
        if ($this->total !== $total) {
            $this->recordThat(AggregateRootStubTotalWasChanged::occur(
                $this->id,
                new AggregateRootStubTotalWasChangedV2Payload(
                    $total
                )
            ));
        }
    }

    public function noApplyMethodExists(): void
    {
        $this->recordThat(AggregateRootStubTotalWasChangedV1::occur(
            $this->id,
            new AggregateRootStubTotalWasChangedPayload(0)
        ));
    }

    public function total(): int
    {
        return $this->total;
    }

    protected function applyAggregateRootStubWasCreated(AggregateRootStubWasCreated $event): void
    {
        $this->id = $event->aggregateId();
        $this->total = $event->payload()->total;
    }

    protected function applyAggregateRootStubTotalWasChanged(AggregateRootStubTotalWasChanged $event): void
    {
        $this->total = $event->payload()->total;
    }
}