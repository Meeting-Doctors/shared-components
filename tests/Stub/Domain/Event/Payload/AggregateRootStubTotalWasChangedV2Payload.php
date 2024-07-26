<?php

declare(strict_types=1);

namespace Shared\Tests\Stub\Domain\Event\Payload;

use Shared\Domain\PayloadInterface;
use Shared\Serializer\SerializableInterface;

readonly class AggregateRootStubTotalWasChangedV2Payload implements PayloadInterface
{
    public function __construct(public int $total)
    {
    }

    public static function deserialize(array $data): SerializableInterface
    {
        return new self($data['total']);
    }

    public function serialize(): array
    {
        return [
            'total' => $this->total,
        ];
    }
}
