<?php

namespace Shared\Tests\Stub\Domain\Event;

use Shared\Domain\DateTimeImmutable;
use Shared\Domain\DomainEvent;
use Shared\Domain\Metadata;
use Shared\Domain\PayloadInterface;
use Shared\Domain\Playhead;
use Shared\Domain\Uuid;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedPayload;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedV2Payload;

readonly class AggregateRootStubTotalWasChangedV1 extends DomainEvent
{
    public AggregateRootStubTotalWasChangedPayload|PayloadInterface $payload;

    public function __construct(
        Uuid                                    $aggregateId,
        AggregateRootStubTotalWasChangedPayload $payload,
        Playhead                                $playhead = null,
        DateTimeImmutable                       $recordedAt = null,
        Metadata                                $metadata = null,
        ?Uuid                                   $id = null
    ) {
        parent::__construct($aggregateId, $payload, $playhead, $recordedAt, $metadata, $id);
    }

    public function payload(): AggregateRootStubTotalWasChangedPayload
    {
        return $this->payload;
    }
}