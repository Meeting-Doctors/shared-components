<?php

declare(strict_types=1);

namespace Shared\EventSourcing\MetadataEnricher;

use Shared\Domain\DomainEvent;
use Shared\Domain\DomainEventStream;
use Shared\Domain\Metadata;
use Shared\EventSourcing\EventStreamDecoratorInterface;

final readonly class MetadataEnrichingEventStreamDecorator implements EventStreamDecoratorInterface
{
    /** @var MetadataEnricherInterface[] */
    private array $enrichers;

    public function __construct(
        MetadataEnricherInterface ...$enrichers
    ) {
        $this->enrichers = $enrichers;
    }

    #[\Override]
    public function decorate(DomainEventStream $stream): DomainEventStream
    {
        $messages = $this->enrich($stream);

        return new DomainEventStream(...$messages);
    }

    /**
     * @return \Generator<DomainEvent>
     */
    private function enrich(DomainEventStream $stream): \Generator
    {
        foreach ($stream->events as $event) {
            $metadata = Metadata::empty();

            foreach ($this->enrichers as $enricher) {
                $metadata = $enricher->enrich($metadata);
            }

            yield $event->withMetadata($metadata);
        }
    }
}
