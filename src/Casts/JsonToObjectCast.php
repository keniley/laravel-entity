<?php

namespace Keniley\LaravelEntity\Casts;

use Keniley\LaravelEntity\Contracts\CastInterface;

final class JsonToObjectCast implements CastInterface
{
    public function cast(mixed $value, mixed $default): mixed
    {
        if ($value instanceof \stdClass) {
            return $value;
        }

        if (! is_string($value)) {
            return $default;
        }

        if (empty($value)) {
            return $default;
        }

        return json_validate($value) ? json_decode($value) : $default;
    }
}
