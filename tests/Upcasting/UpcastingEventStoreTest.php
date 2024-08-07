<?php

declare(strict_types=1);

namespace Shared\Tests\Upcasting;

use PHPUnit\Framework\TestCase;
use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;
use Shared\Tests\EventStore\InMemoryEventStore;
use Shared\Tests\Stub\Domain\Event\AggregateRootStubTotalWasChanged;
use Shared\Tests\Stub\Domain\Event\AggregateRootStubTotalWasChangedV1;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedPayload;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedV2Payload;
use Shared\Tests\Stub\Domain\Event\Upcast\AggregateRootStubTotalWasChangedV1ToV2;
use Shared\Upcasting\SequentialUpcasterChain;
use Shared\Upcasting\UpcastingEventStore;

final class UpcastingEventStoreTest extends TestCase
{
    public function test_must_upcast_event_when_stream_is_not_empty(): void
    {
        $store = new UpcastingEventStore(
            new InMemoryEventStore(),
            new SequentialUpcasterChain(
                new AggregateRootStubTotalWasChangedV1ToV2()
            )
        );

        $store->append(new DomainEventStream(AggregateRootStubTotalWasChangedV1::occur(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            new AggregateRootStubTotalWasChangedPayload(1)
        )));

        $stream = $store->load(new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'));

        $events = $stream->events;
        $event = $events[0];
        $payload = $event->payload();

        self::assertInstanceOf(AggregateRootStubTotalWasChanged::class, $event);
        self::assertInstanceOf(AggregateRootStubTotalWasChangedV2Payload::class, $payload);
    }
}
