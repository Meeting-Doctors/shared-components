<?php

declare(strict_types=1);

namespace Shared\Upcasting;

use Shared\Domain\DomainEvent;

interface UpcasterInterface
{
    public function supports(DomainEvent $event): bool;

    public function upcast(DomainEvent $event): DomainEvent;
}
