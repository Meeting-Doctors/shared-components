<?php

declare(strict_types=1);

namespace Shared\EventSourcing;

use Shared\Domain\DomainEvent;

abstract class AbstractEventSourcedEntity implements EventSourcedEntityInterface
{
    private ?AbstractEventSourcedAggregateRoot $aggregateRoot = null;

    /**
     * @throws AggregateRootAlreadyExistsException
     */
    final protected function apply(DomainEvent $event): void
    {
        //$this->aggregateRoot->apply($event);
    }

    /**
     * @throws AggregateRootAlreadyExistsException
     */
    #[\Override]
    final public function handleRecursively(DomainEvent $event): void
    {
        $this->handle($event);

        foreach ($this->childEntities() as $entity) {
            $entity->setAggregateRoot($this->aggregateRoot);
            $entity->handleRecursively($event);
        }
    }

    /**
     * @throws AggregateRootAlreadyExistsException
     */
    #[\Override]
    final public function setAggregateRoot(AbstractEventSourcedAggregateRoot $aggregateRoot): void
    {
        if (
            $this->aggregateRoot instanceof AbstractEventSourcedAggregateRoot
            && $this->aggregateRoot !== $aggregateRoot
        ) {
            throw AggregateRootAlreadyExistsException::new($this->aggregateRoot);
        }

        $this->aggregateRoot = $aggregateRoot;
    }

    /**
     * @return EventSourcedEntityInterface[]
     */
    protected function childEntities(): array
    {
        return [];
    }

    private function handle(DomainEvent $event): void
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
