<?php

declare(strict_types=1);

namespace Shared\Tests\Specification;

use PHPUnit\Framework\TestCase;
use Shared\Tests\Stub\Domain\Specification\SpecificationStub;
use Shared\Tests\Stub\Domain\Specification\ThrowableSpecification;

final class UniqueSpecificationTest extends TestCase
{
    public function test_must_throw_exception_when_guard_is_not_unique(): void
    {
        self::expectException(\Exception::class);

        $specification = new ThrowableSpecification();

        $specification->isUnique();
    }

    public function test_must_guard_is_unique(): void
    {
        $specification = new SpecificationStub();

        $isUnique = $specification->isUnique();

        self::assertTrue($isUnique);
    }
}
