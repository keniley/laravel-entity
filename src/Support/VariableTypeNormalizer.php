<?php

namespace Keniley\LaravelEntity\Support;

class VariableTypeNormalizer
{
    public static function normalize(string $type): string
    {
        $type = strtolower($type);

        return match ($type) {
            'bool', 'boolean' => 'bool',
            'int', 'integer' => 'int',
            'float', 'double', 'real' => 'float',
            default => $type,
        };
    }
}
