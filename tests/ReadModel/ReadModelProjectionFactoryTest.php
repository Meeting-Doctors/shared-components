<?php

declare(strict_types=1);

namespace Shared\Tests\ReadModel;

use PHPUnit\Framework\TestCase;
use Shared\Domain\PayloadInterface;
use Shared\Domain\Uuid;
use Shared\Tests\InMemoryCollector;
use Shared\Tests\Stub\Domain\Event\AggregateRootStubWasCreated;
use Shared\Tests\Stub\Domain\Event\DomainEventStub;
use Shared\Tests\Stub\Domain\Event\Payload\AggregateRootStubWasCreatedPayload;
use Shared\Tests\Stub\Domain\Event\Payload\DomainEventStubPayload;
use Shared\Tests\Stub\Domain\ReadModel\Factory\AggregateRootStubProjectionFactory;

final class ReadModelProjectionFactoryTest extends TestCase
{
    public function test_must_apply_specific_event_when_method_exists(): void
    {
        $collector = new InMemoryCollector();
        $projector = new AggregateRootStubProjectionFactory($collector);

        $projector->handle(DomainEventStub::occur(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            new DomainEventStubPayload()
        ));

        /** @var PayloadInterface[] $events */
        $events = $collector->objects();
        $event = $events[0];

        self::assertInstanceOf(DomainEventStub::class, $event);
    }

    public function test_must_apply_specific_event_when_method_not_exists(): void
    {
        $collector = new InMemoryCollector();
        $projector = new AggregateRootStubProjectionFactory($collector);

        $projector->handle(AggregateRootStubWasCreated::occur(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            new AggregateRootStubWasCreatedPayload(1)
        ));

        /** @var PayloadInterface[] $events */
        $events = $collector->objects();

        self::assertEmpty($events);
    }
}
