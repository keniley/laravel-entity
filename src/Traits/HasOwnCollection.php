<?php

namespace Keniley\LaravelEntity\Traits;

use Keniley\LaravelEntity\Attributes\HasCollection;
use Keniley\LaravelEntity\Collections\EntityCollection;

trait HasOwnCollection
{
    use HasClassAttributes;

    public static function collection(): ?EntityCollection
    {
        /** @var \ReflectionAttribute|null $entityClass */
        $entityClass = static::getClassAttributes(HasCollection::class)->first();

        return $entityClass?->newInstance()->getCollection();
    }
}
