<?php

declare(strict_types=1);

namespace Shared\Tests\Stub\Domain\Event;

use Shared\Domain\DomainEvent;
use Shared\Domain\PayloadInterface;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedPayload;

readonly class AggregateRootStubTotalWasChangedV1 extends DomainEvent
{
    public function payload(): AggregateRootStubTotalWasChangedPayload|PayloadInterface
    {
        return $this->payload;
    }
}
