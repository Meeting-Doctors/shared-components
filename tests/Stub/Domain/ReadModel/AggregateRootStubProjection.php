<?php

namespace Shared\Tests\Stub\Domain\ReadModel;

use Assert\Assertion;
use Shared\Domain\Uuid;
use Shared\ReadModel\SerializableReadModelInterface;

class AggregateRootStubProjection implements SerializableReadModelInterface
{
    private function __construct(
        public Uuid $id,
    ) {
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'id');

        return new self(
            new Uuid($data['id']),
        );
    }

    #[\Override]
    public function serialize(): array
    {
        return [
            'id' => $this->id->uuid,
        ];
    }

    #[\Override]
    public function id(): Uuid
    {
        return $this->id;
    }
}