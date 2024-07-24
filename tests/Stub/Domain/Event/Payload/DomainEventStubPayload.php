<?php

namespace Shared\Tests\Stub\Domain\Event\Payload;

use Shared\Domain\PayloadInterface;
use Shared\Serializer\SerializableInterface;

readonly class DomainEventStubPayload implements PayloadInterface
{
    public static function deserialize(array $data): SerializableInterface
    {
        return new self();
    }

    public function serialize(): array
    {
        return [];
    }
}
