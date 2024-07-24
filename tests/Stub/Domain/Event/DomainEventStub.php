<?php

namespace Shared\Tests\Stub\Domain\Event;

use Shared\Domain\DateTimeImmutable;
use Shared\Domain\DomainEvent;
use Shared\Domain\Metadata;
use Shared\Domain\PayloadInterface;
use Shared\Domain\PlayHead;
use Shared\Domain\Uuid;
use Shared\Tests\Stub\Domain\Event\Payload\DomainEventStubPayload;

readonly class DomainEventStub extends DomainEvent
{
    public DomainEventStubPayload|PayloadInterface $payload;

    public function __construct(
        Uuid $aggregateId,
        DomainEventStubPayload $payload,
        PlayHead $playHead,
        DateTimeImmutable $recordedAt,
        Metadata $metadata,
        ?Uuid $id = null
    ) {
        parent::__construct($aggregateId, $payload, $playHead, $recordedAt, $metadata, $id);
    }

    public function payload(): DomainEventStubPayload
    {
        return $this->payload;
    }
}
