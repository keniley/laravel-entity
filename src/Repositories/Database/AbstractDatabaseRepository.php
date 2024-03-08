<?php

namespace Keniley\LaravelEntity\Repositories\Database;

use Keniley\LaravelEntity\Entity;
use Keniley\LaravelEntity\Repositories\AbstractRepository;

abstract class AbstractDatabaseRepository extends AbstractRepository
{
    protected function load($data): Entity
    {
        $data = json_decode(json_encode($data), true);

        return parent::load(data: $data);
    }

    protected function loadOrNull($data): ?Entity
    {
        if (empty($data)) {
            return null;
        }

        return $this->load(data: $data);
    }
}
