<?php

namespace Shared\Tests\Stub\Domain\Event\Upcast;

use Shared\Domain\DomainEvent;
use Shared\Domain\Uuid;
use Shared\Tests\Stub\Domain\Event\AggregateRootStubTotalWasChanged;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedPayload;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedV2Payload;
use Shared\Upcasting\UpcasterInterface;

readonly class AggregateRootStubTotalWasChangedV1ToV2 implements UpcasterInterface
{
    public function supports(DomainEvent|AggregateRootStubTotalWasChanged $event): bool
    {
        return $event->payload() instanceof AggregateRootStubTotalWasChangedPayload;
    }

    public function upcast(DomainEvent $event): DomainEvent
    {
        $newPayload = new AggregateRootStubTotalWasChangedV2Payload(23);

        return new AggregateRootStubTotalWasChanged(
            $event->aggregateId(),
            $newPayload,
            $event->playhead(),
            $event->recordedAt(),
            $event->metadata(),
            $event->id()
        );
    }
}