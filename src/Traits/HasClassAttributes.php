<?php

namespace Keniley\LaravelEntity\Traits;

use Illuminate\Support\Collection;
use ReflectionClass;

trait HasClassAttributes
{
    public static function getClassAttributes(?string $typeOf = null): Collection
    {
        $class = new ReflectionClass(static::class);

        if (empty($typeOf)) {
            return collect($class->getAttributes());
        }

        return collect($class->getAttributes($typeOf));
    }
}
