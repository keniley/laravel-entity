<?php

namespace Keniley\LaravelEntity\Contracts;

use Keniley\LaravelEntity\Entity;

interface RepositoryInterface
{
    /**
     * Insert new or update existed entity in storage
     */
    public function save(Entity $entity): ?Entity;

    /**
     * Delete existed entity in storage
     */
    public function delete(Entity $entity): bool;
}
