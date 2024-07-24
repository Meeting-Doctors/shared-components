<?php

namespace Shared\Tests\Stub\Domain\Event;

use Shared\Domain\DateTimeImmutable;
use Shared\Domain\DomainEvent;
use Shared\Domain\Metadata;
use Shared\Domain\PayloadInterface;
use Shared\Domain\PlayHead;
use Shared\Domain\Uuid;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubWasCreatedPayload;

readonly class AggregateRootStubWasCreated extends DomainEvent
{
    public AggregateRootStubWasCreatedPayload|PayloadInterface $payload;

    public function __construct(
        Uuid $aggregateId,
        AggregateRootStubWasCreatedPayload $payload,
        PlayHead $playHead,
        DateTimeImmutable $recordedAt,
        Metadata $metadata,
        ?Uuid $id = null
    ) {
        parent::__construct($aggregateId, $payload, $playHead, $recordedAt, $metadata, $id);
    }

    public function payload(): AggregateRootStubWasCreatedPayload
    {
        return $this->payload;
    }
}
