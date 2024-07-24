<?php

declare(strict_types=1);

namespace Shared\Tests\CommandHandling;

use PHPUnit\Framework\TestCase;
use Shared\CommandHandling\Collection;
use Shared\CommandHandling\Item;
use Shared\CommandHandling\PageNotFoundException;
use Shared\Tests\Stub\Domain\ReadModel\AggregateRootStubProjection;

final class CollectionTest extends TestCase
{
    public function test_must_throw_not_found_exception_when_page_not_exists(): void
    {
        self::expectException(PageNotFoundException::class);

        new Collection(2, 10, 2, []);
    }

    public function test_must_collect_item(): void
    {
        $collection = new Collection(1, 10, 0, []);

        self::assertInstanceOf(Collection::class, $collection);

        $collection = new Collection(1, 10, 1, [
            Item::fromSerializable(AggregateRootStubProjection::deserialize([
                'id' => '9db0db88-3e44-4d2b-b46f-9ca547de06ac',
            ])),
        ]);

        self::assertInstanceOf(Collection::class, $collection);
    }
}
