<?php

declare(strict_types=1);

namespace Shared\Tests\EventHandling;

use PHPUnit\Framework\TestCase;
use Shared\Domain\DomainEvent;
use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;
use Shared\EventHandling\EventBusException;
use Shared\EventHandling\SimpleEventBus;
use Shared\Tests\InMemoryCollector;
use Shared\Tests\Stub\Domain\Event\DomainEventStub;
use Shared\Tests\Stub\Domain\Event\Payload\DomainEventStubPayload;
use Shared\Tests\Stub\Domain\Listener\EventListenerStub;
use Shared\Tests\Stub\Domain\Listener\ThrowableEventListener;

final class SimpleEventBusTest extends TestCase
{
    public function test_must_throw_an_event_bus_exception(): void
    {
        self::expectException(EventBusException::class);

        $message = DomainEventStub::occur(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            new DomainEventStubPayload()
        );

        $bus = new SimpleEventBus();
        $bus->subscribe(new ThrowableEventListener());

        $bus->publish(new DomainEventStream($message));
    }

    public function test_must_publish_a_message(): void
    {
        $message = DomainEventStub::occur(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            new DomainEventStubPayload()
        );

        $bus = new SimpleEventBus();
        $collector = new InMemoryCollector();
        $bus->subscribe(new EventListenerStub($collector));

        $bus->publish(new DomainEventStream($message));

        /** @var DomainEvent[] $events */
        $events = $collector->objects();
        $event = $events[0];
        $event = $event->payload();

        self::assertInstanceOf(DomainEventStubPayload::class, $event);
    }
}
