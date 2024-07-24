<?php

declare(strict_types=1);

namespace Shared\Tests\EventSourcing\MetadataEnricher;

use PHPUnit\Framework\TestCase;
use Shared\Domain\DomainEventStream;
use Shared\Domain\Uuid;
use Shared\EventSourcing\MetadataEnricher\MetadataEnrichingEventStreamDecorator;
use Shared\Tests\Stub\Domain\Event\DomainEventStub;
use Shared\Tests\Stub\Domain\Event\MetadataEnricher\MetadataEnricherStub;
use Shared\Tests\Stub\Domain\Event\Payload\DomainEventStubPayload;

final class MetadataEnrichingEventStreamDecoratorTest extends TestCase
{
    public function test_must_enrich_metadata(): void
    {
        $decorator = new MetadataEnrichingEventStreamDecorator(
            new MetadataEnricherStub()
        );

        $stream = $decorator->decorate(new DomainEventStream(DomainEventStub::occur(
            new Uuid('9db0db88-3e44-4d2b-b46f-9ca547de06ac'),
            new DomainEventStubPayload()
        )));

        $events = $stream->events;
        $event = $events[0];
        $metadata = $event->metadata();

        self::assertSame(['foo' => 'bar'], $metadata->values);
    }
}
