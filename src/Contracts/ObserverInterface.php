<?php

namespace Keniley\LaravelEntity\Contracts;

use Keniley\LaravelEntity\Entity;

interface ObserverInterface
{
    public function retrieved(Entity $entity);

    public function saving(Entity $entity);

    public function saved(Entity $entity);

    public function deleting(Entity $entity);

    public function deleted(Entity $entity);
}
