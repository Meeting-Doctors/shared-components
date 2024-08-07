<?php

namespace Shared\Tests\EventStore;

use PHPUnit\Framework\TestCase;
use Shared\Domain\DomainEvent;
use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;
use Shared\EventStore\CallableEventVisitor;
use Shared\EventStore\EventStoreManager;
use Shared\Tests\Stub\Domain\Event\AggregateRootStubTotalWasChanged;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedV2Payload;

class EventStoreManagerTest extends TestCase
{
    public function test_visit_events(): void
    {
        $store = new InMemoryEventStore();
        $store->append(new DomainEventStream(AggregateRootStubTotalWasChanged::occur(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            new AggregateRootStubTotalWasChangedV2Payload(42)
        )));
        $manager = new EventStoreManager($store);

        $events = [];

        $manager->visitEvents(new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'), new CallableEventVisitor(
            static function (DomainEvent $event) use (&$events): void {
                $events[] = $event;
            }
        ));

        $event = $events[0];
        $payload = $event->payload();
        self::assertInstanceOf(DomainEvent::class, $event);
        self::assertInstanceOf(AggregateRootStubTotalWasChangedV2Payload::class, $payload);
    }
}
