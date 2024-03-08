<?php

namespace Keniley\LaravelEntity\Contracts;

interface CastInterface
{
    public function cast(mixed $value, mixed $default): mixed;
}
