<?php

declare(strict_types=1);

namespace Shared\Domain;

abstract readonly class DomainEvent
{
    final public function __construct(
        protected Uuid $aggregateId,
        protected PayloadInterface $payload,
        protected Playhead $playhead,
        protected DateTimeImmutable $recordedAt,
        protected Metadata $metadata,
        protected Uuid $id
    ) {
    }

    public static function occur(
        Uuid $aggregateId,
        PayloadInterface $payload
    ): self {
        return new static(
            $aggregateId,
            $payload,
            Playhead::zero(),
            DateTimeImmutable::now(),
            Metadata::empty(),
            Uuid::uuid4()
        );
    }

    public function withPlayhead(Playhead $playhead): self
    {
        return new static(
            $this->aggregateId,
            $this->payload,
            $playhead,
            $this->recordedAt,
            $this->metadata,
            $this->id,
        );
    }

    public function withMetadata(Metadata $metadata): self
    {
        return new static(
            $this->aggregateId,
            $this->payload,
            $this->playhead,
            $this->recordedAt,
            $this->metadata->merge($metadata),
            $this->id,
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function aggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    public function payload(): PayloadInterface
    {
        return $this->payload;
    }

    public function playhead(): Playhead
    {
        return $this->playhead;
    }

    public function recordedAt(): DateTimeImmutable
    {
        return $this->recordedAt;
    }

    public function metadata(): Metadata
    {
        return $this->metadata;
    }
}
