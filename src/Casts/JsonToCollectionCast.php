<?php

namespace Keniley\LaravelEntity\Casts;

use Illuminate\Support\Collection;
use Keniley\LaravelEntity\Contracts\CastInterface;

final class JsonToCollectionCast implements CastInterface
{
    public function cast(mixed $value, mixed $default): Collection
    {
        if ($value instanceof Collection) {
            return $value;
        }

        if (! is_string($value)) {
            return $default;
        }

        if (empty($value)) {
            return $default;
        }

        return json_validate($value) ? collect(json_decode($value, true)) : $default;
    }
}
