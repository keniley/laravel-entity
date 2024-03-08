<?php

namespace Keniley\LaravelEntity\Repositories;

use Keniley\LaravelEntity\Collections\EntityCollection;
use Keniley\LaravelEntity\Contracts\RepositoryInterface;
use Keniley\LaravelEntity\Entity;
use Keniley\LaravelEntity\Enums\EntityEvent;

abstract class AbstractRepository implements RepositoryInterface
{
    protected string $entity;

    public function save(Entity $entity): Entity
    {
        if (! $entity->fireEvent(EntityEvent::SAVING)) {
            return $entity;
        }

        $saved = $this->onSave($entity);

        if ($saved) {
            $event = $entity->fireEvent(EntityEvent::SAVED);
        }

        return $entity;
    }

    public function delete(Entity $entity): bool
    {
        if (! $entity->fireEvent(EntityEvent::DELETING)) {
            return false;
        }

        $deleted = $this->onDelete($entity);

        if ($deleted) {
            $event = $entity->fireEvent(EntityEvent::DELETED);
            unset($entity);
        }

        return true;
    }

    abstract protected function onSave(Entity $entity): bool;

    abstract protected function onDelete(Entity $entity): bool;

    protected function load(array $data): Entity
    {
        /** @var Entity $entity */
        $entity = new $this->entity();
        $entity->fromSource(raw: $data);

        return $entity;
    }

    protected function loadMulti(array $data): EntityCollection
    {
        /** @var EntityCollection $collection */
        $collection = $this->entity::collection();

        foreach ($data as $item) {
            $collection->push($this->load($item));
        }

        return $collection;
    }
}
