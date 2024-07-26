<?php

declare(strict_types=1);

namespace Shared\Tests\Stub\Domain\Specification;

use Shared\Specification\AbstractSpecification;

readonly class SpecificationStub extends AbstractSpecification
{
    public function isUnique(): bool
    {
        return $this->isSatisfiedBy();
    }

    #[\Override]
    protected function isSatisfiedBy(mixed ...$params): bool
    {
        return true;
    }
}
