<?php

declare(strict_types=1);

namespace Shared\Tests\Stub\Domain\Event\MetadataEnricher;

use Shared\Domain\Metadata;
use Shared\EventSourcing\MetadataEnricher\MetadataEnricherInterface;

final readonly class MetadataEnricherStub implements MetadataEnricherInterface
{
    #[\Override]
    public function enrich(Metadata $metadata): Metadata
    {
        return $metadata->merge(Metadata::kv('foo', 'bar'));
    }
}
