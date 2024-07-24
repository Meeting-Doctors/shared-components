<?php

declare(strict_types=1);

namespace Shared\Domain;

abstract readonly class DomainEvent
{
    protected string $type;

    public function __construct(
        protected Uuid $aggregateId,
        protected PayloadInterface $payload,
        protected PlayHead $playHead,
        protected DateTimeImmutable $recordedAt,
        protected Metadata $metadata,
        protected Uuid $id
    ) {
        $this->type = strtr(self::class, '\\', '.');
    }

    public static function occur(
        Uuid $aggregateId,
        PayloadInterface $payload
    ): self {
        return new static(
            $aggregateId,
            $payload,
            PlayHead::zero(),
            DateTimeImmutable::now(),
            Metadata::empty(),
            Uuid::uuid4()
        );
    }

    public function withPlayHead(PlayHead $playHead): self
    {
        return new static(
            $this->aggregateId,
            $this->payload,
            $playHead,
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
            $this->playHead,
            $this->recordedAt,
            $this->metadata->merge($metadata),
            $this->id,
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function aggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    public function payload(): PayloadInterface
    {
        return $this->payload;
    }

    public function playHead(): PlayHead
    {
        return $this->playHead;
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
