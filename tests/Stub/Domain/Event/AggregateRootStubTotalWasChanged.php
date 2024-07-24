<?php

namespace Shared\Tests\Stub\Domain\Event;

use Shared\Domain\DateTimeImmutable;
use Shared\Domain\DomainEvent;
use Shared\Domain\Metadata;
use Shared\Domain\PayloadInterface;
use Shared\Domain\PlayHead;
use Shared\Domain\Uuid;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedPayload;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedV2Payload;

readonly class AggregateRootStubTotalWasChanged extends DomainEvent
{
    public AggregateRootStubTotalWasChangedV2Payload|PayloadInterface $payload;

    public function __construct(
        Uuid $aggregateId,
        AggregateRootStubTotalWasChangedV2Payload $payload,
        PlayHead $playHead = null,
        DateTimeImmutable $recordedAt = null,
        Metadata $metadata = null,
        ?Uuid $id = null
    ) {
        parent::__construct($aggregateId, $payload, $playHead, $recordedAt, $metadata, $id);
    }


    public function payload(): AggregateRootStubTotalWasChangedV2Payload
    {
        return $this->payload;
    }
}