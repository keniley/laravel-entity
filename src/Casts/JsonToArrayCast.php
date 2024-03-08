<?php

namespace Keniley\LaravelEntity\Casts;

use Keniley\LaravelEntity\Contracts\CastInterface;

final class JsonToArrayCast implements CastInterface
{
    /**
     * @return null|array<mixed, mixed>
     */
    public function cast(mixed $value, mixed $default): ?array
    {
        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value)) {
            return $default;
        }

        if (empty($value)) {
            return $default;
        }

        return json_validate($value) ? json_decode($value, true) : $default;
    }
}
