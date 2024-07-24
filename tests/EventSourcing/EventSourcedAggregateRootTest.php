<?php

declare(strict_types=1);

namespace Shared\Tests\EventSourcing;

use PHPUnit\Framework\TestCase;
use Shared\Domain\DomainEvent;
use Shared\Domain\Uuid;
use Shared\Tests\Stub\Domain\AggregateRootStub;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubTotalWasChangedPayload;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubWasCreatedPayload;

final class EventSourcedAggregateRootTest extends TestCase
{
    public function test_must_apply_specific_event_when_method_exists(): void
    {
        $aggregateRoot = AggregateRootStub::create(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            1
        );

        $stream = $aggregateRoot->uncommittedEvents();
        $events = $stream->events;
        $event = $events[0];
        $payload = $event->payload();

        self::assertInstanceOf(DomainEvent::class, $event);
        self::assertInstanceOf(AggregateRootStubWasCreatedPayload::class, $payload);
        self::assertSame($aggregateRoot->id(), $event->aggregateId());
        self::assertSame($aggregateRoot->playHead(), $event->playHead());
    }

    public function test_must_apply_specific_event_when_method_not_exists(): void
    {
        $aggregateRoot = AggregateRootStub::create(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            1
        );
        $aggregateRoot->uncommittedEvents();

        $aggregateRoot->noApplyMethodExists();

        $stream = $aggregateRoot->uncommittedEvents();
        $events = $stream->events;
        $event = $events[0];
        $payload = $event->payload();

        self::assertInstanceOf(DomainEvent::class, $event);
        self::assertInstanceOf(AggregateRootStubTotalWasChangedPayload::class, $payload);
        self::assertSame($aggregateRoot->id(), $event->aggregateId());
        self::assertSame($aggregateRoot->playHead(), $event->playHead());
    }
}
