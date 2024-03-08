<?php

namespace Keniley\LaravelEntity\Collections;

use Keniley\LaravelEntity\Collection;
use Keniley\LaravelEntity\Entity;

class EntityCollection extends Collection
{
    protected string $instanceOf = Entity::class;
}
