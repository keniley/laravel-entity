<?php

namespace Keniley\LaravelEntity\Support;

use ReflectionNamedType;
use ReflectionProperty;

class PropertyInfo
{
    public readonly string $name;

    public readonly bool $isBuildIn;

    public readonly string $type;

    public readonly bool $isNull;

    public mixed $default;

    public function __construct(ReflectionProperty $property)
    {
        $this->name = $property->getDeclaringClass()->getName().'::'.$property->getName();
        $isBuildIn = true;
        $type = 'mixed';
        $isNull = false;
        $this->default = $property->getDefaultValue();

        $propertyType = $property->getType();

        if ($propertyType instanceof ReflectionNamedType) {
            $isNull = $propertyType->allowsNull();
            $isBuildIn = $propertyType->isBuiltin();
            $type = VariableTypeNormalizer::normalize($propertyType->getName());
        }

        $this->type = $type;
        $this->isNull = $isNull;
        $this->isBuildIn = $isBuildIn;
    }
}
