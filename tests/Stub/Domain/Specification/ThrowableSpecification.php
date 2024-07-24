<?php

namespace Shared\Tests\Stub\Domain\Specification;

use Shared\Specification\AbstractSpecification;

readonly class ThrowableSpecification extends AbstractSpecification
{
    /**
     * @throws \Exception
     */
    public function isUnique(): bool
    {
        return $this->isSatisfiedBy();
    }

    /**
     * @throws \Exception
     */
    #[\Override]
    protected function isSatisfiedBy(mixed ...$params): bool
    {
        throw new \Exception();
    }
}
