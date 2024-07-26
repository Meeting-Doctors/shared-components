<?php

declare(strict_types=1);

namespace Shared\Tests\Stub\Domain\Event;

use Shared\Domain\DomainEvent;
use Shared\Domain\PayloadInterface;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedV2Payload;

readonly class AggregateRootStubTotalWasChanged extends DomainEvent
{
    public function payload(): AggregateRootStubTotalWasChangedV2Payload|PayloadInterface
    {
        return $this->payload;
    }
}
