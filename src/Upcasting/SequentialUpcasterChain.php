<?php

declare(strict_types=1);

namespace Shared\Upcasting;

use Shared\Domain\DomainEvent;

final readonly class SequentialUpcasterChain implements UpcasterInterface
{
    /** @var UpcasterInterface[] */
    private array $upcasters;

    public function __construct(
        UpcasterInterface ...$upcasters
    ) {
        $this->upcasters = $upcasters;
    }

    #[\Override]
    public function supports(DomainEvent $event): bool
    {
        foreach ($this->upcasters as $upcaster) {
            if ($upcaster->supports($event)) {
                return true;
            }
        }

        return false;
    }

    #[\Override]
    public function upcast(DomainEvent $event): DomainEvent
    {
        foreach ($this->upcasters as $upcaster) {
            if ($upcaster->supports($event)) {
                $event = $upcaster->upcast($event);
            }
        }

        return $event;
    }
}
