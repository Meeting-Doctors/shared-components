<?php

declare(strict_types=1);

namespace Shared\Tests\EventSourcing;

use PHPUnit\Framework\TestCase;
use Shared\Domain\Uuid;
use Shared\EventHandling\SimpleEventBus;
use Shared\EventSourcing\Factory\PublicConstructorAggregateRootFactory;
use Shared\EventSourcing\MetadataEnricher\MetadataEnrichingEventStreamDecorator;
use Shared\EventStore\DomainEventStreamNotFoundException;
use Shared\Tests\EventStore\InMemoryEventStore;
use Shared\Tests\Stub\Domain\AggregateRootStub;
use Shared\Tests\Stub\Infrastructure\Repository\AggregateRootStubRepository;

final class EventSourcingRepositoryTest extends TestCase
{
    public function test_must_throw_domain_event_stream_not_found_exception_when_aggregate_root_is_not_stored(): void
    {
        self::expectException(DomainEventStreamNotFoundException::class);

        $store = new AggregateRootStubRepository(
            new InMemoryEventStore(),
            new SimpleEventBus(),
            new MetadataEnrichingEventStreamDecorator(),
            new PublicConstructorAggregateRootFactory(AggregateRootStub::class)
        );

        $store->get(new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'));
    }

    public function test_must_get_aggregate_root_when_aggregate_root_is_stored(): void
    {
        $aggregateRoot = AggregateRootStub::create(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
        );

        $store = new AggregateRootStubRepository(
            new InMemoryEventStore(),
            new SimpleEventBus(),
            new MetadataEnrichingEventStreamDecorator(),
            new PublicConstructorAggregateRootFactory(AggregateRootStub::class)
        );

        $store->store($aggregateRoot);

        $aggregateRoot = $store->get(new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'));

        self::assertInstanceOf(AggregateRootStub::class, $aggregateRoot);
    }
}
