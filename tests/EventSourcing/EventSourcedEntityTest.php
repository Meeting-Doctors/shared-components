<?php

declare(strict_types=1);

namespace Shared\Tests\EventSourcing;

use PHPUnit\Framework\TestCase;
use Shared\Domain\DomainEvent;
use Shared\Domain\Uuid;
use Shared\Tests\Stub\Domain\AggregateRootStub;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedV2Payload;

final class EventSourcedEntityTest extends TestCase
{
    public function test_must_apply_specific_event_when_method_exists(): void
    {
        $aggregateRoot = AggregateRootStub::create(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            1
        );

        $aggregateRoot->uncommittedEvents();

        $aggregateRoot->changeTotal(2);

        $stream = $aggregateRoot->uncommittedEvents();
        $events = $stream->events;
        $event = $events[0];
        $payload = $event->payload();

        self::assertInstanceOf(DomainEvent::class, $event);
        self::assertInstanceOf(AggregateRootStubTotalWasChangedV2Payload::class, $payload);
        self::assertSame($aggregateRoot->id(), $event->aggregateId());
        self::assertSame($aggregateRoot->playHead(), $event->playHead());
/*
        $aggregateRoot->bazAttachment(new Uuid('c467bd14-4265-41f5-9101-5df03595e2a6'));

        $stream = $aggregateRoot->uncommittedEvents();
        $events = $stream->events;
        $event = $events[0];
        $payload = $event->payload;

        self::assertInstanceOf(DomainEvent::class, $event);
        self::assertInstanceOf(AnAggregatedEntityWasBazed::class, $payload);
        self::assertSame($aggregateRoot->id(), $event->id);
        self::assertSame($aggregateRoot->playHead(), $event->playHead);
*/
    }
}