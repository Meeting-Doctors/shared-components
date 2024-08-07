<?php

declare(strict_types=1);

namespace Shared\ReadModel;

use Shared\Domain\DomainEvent;

abstract readonly class AbstractProjector
{
    final public function handle(DomainEvent $event): void
    {
        $method = $this->applyMethod($event);

        if (!method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    private function applyMethod(DomainEvent $event): string
    {
        $fqcn = explode('\\', $event::class);

        return sprintf('apply%s', end($fqcn));
    }
}
