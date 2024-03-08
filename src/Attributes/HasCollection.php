<?php

namespace Keniley\LaravelEntity\Attributes;

use Keniley\LaravelEntity\Collections\EntityCollection;

#[\Attribute]
final readonly class HasCollection
{
    public function __construct(private ?string $collection = null)
    {
    }

    public function hasCollection(): bool
    {
        return ! empty($this->collection);
    }

    public function getCollection(): ?EntityCollection
    {
        if (! $this->hasCollection()) {
            return resolve(EntityCollection::class);
        }

        $class = resolve($this->collection);

        if ($class instanceof EntityCollection) {
            return $class;
        }

        return resolve(EntityCollection::class);
    }
}
