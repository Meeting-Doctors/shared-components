<?php

declare(strict_types=1);

namespace Shared\Tests\Stub\Domain\Event;

use Shared\Domain\DomainEvent;
use Shared\Domain\PayloadInterface;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubWasCreatedPayload;

readonly class AggregateRootStubWasCreated extends DomainEvent
{
    public function payload(): AggregateRootStubWasCreatedPayload|PayloadInterface
    {
        return $this->payload;
    }
}
