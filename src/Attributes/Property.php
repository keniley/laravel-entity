<?php

namespace Keniley\LaravelEntity\Attributes;

use Illuminate\Support\Str;
use Keniley\LaravelEntity\Contracts\CastInterface;
use Keniley\LaravelEntity\Contracts\DefaultValueInterface;
use Keniley\LaravelEntity\Support\VariableTypeNormalizer;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;

#[\Attribute]
final class Property
{
    private const NODEFAULT = '---[NO-DEFAULT]---';

    public function __construct(
        private bool $protected = false,
        private mixed $cast = null,
        private bool $autoUuid = false,
        private mixed $default = self::NODEFAULT,
        private mixed $defaultParam = null,
        private bool $hidden = false
    ) {
    }

    public function isProtected(): bool
    {
        return $this->protected;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function getAutoUuid(ReflectionProperty $property): ?string
    {
        if (! $this->isAutoUuid()) {
            return null;
        }

        $type = 'mixed';
        $propertyType = $property->getType();

        if ($propertyType instanceof ReflectionNamedType) {
            $type = VariableTypeNormalizer::normalize($propertyType->getName());
        }

        if (! in_array($type, ['string', 'mixed'])) {
            throw new \TypeError('Can not assign uuid to property of type '.$type);
        }

        if ($this->hasOwnCast() && ! in_array($this->getCastRule(), ['string', 'mixed'])) {
            throw new \TypeError('Can not assign uuid to property with cast rule '.$this->getCastRule());
        }

        return Str::uuid()->toString();
    }

    public function isAutoUuid(): bool
    {
        return $this->autoUuid;
    }

    public function hasDefaultValue(): bool
    {
        return $this->default !== self::NODEFAULT;
    }

    public function getDefaultValue(): mixed
    {
        if (VariableTypeNormalizer::normalize(gettype($this->default)) !== 'string') {
            return $this->default;
        }

        if (! class_exists($this->default)) {
            return $this->default;
        }

        $classReflection = new ReflectionClass($this->default);

        if ($classReflection->implementsInterface(DefaultValueInterface::class)) {
            /** @var DefaultValueInterface $class */
            $class = resolve($this->default);

            return $class->get(parameter: $this->defaultParam);
        }

        return $this->default;
    }

    public function hasOwnCast(): bool
    {
        return $this->cast !== null;
    }

    public function getCastRule(): ?string
    {
        return $this->cast;
    }

    public function cast(mixed $value, mixed $default, ?string $cast = null, bool $force = false): mixed
    {
        if (! empty($cast)) {
            $this->cast = $cast;
        }

        return match ($this->cast) {
            'string' => $this->castString($value, $default, $force),
            'int' => $this->castInt($value, $default, $force),
            'float' => $this->castFloat($value, $default, $force),
            'bool' => $this->castBool($value, $default, $force),
            'array' => $this->castArray($value, $default, $force),
            'object' => $this->castObject($value, $default, $force),
            default => $this->castClass($value, $default, $force)
        };
    }

    protected function castInt(mixed $value, mixed $default, bool $force = false): mixed
    {
        settype($value, $this->cast);

        if (empty($value) && ! $force) {
            return $default;
        }

        return $value;
    }

    protected function castString(mixed $value, mixed $default, bool $force = false): mixed
    {
        settype($value, $this->cast);

        if (empty($value) && ! $force) {
            return $default;
        }

        return $value;
    }

    protected function castBool(mixed $value, mixed $default, bool $force = false): mixed
    {
        if ($value === null && ! $force) {
            return $default;
        }

        settype($value, $this->cast);

        return $value;
    }

    protected function castFloat(mixed $value, mixed $default, bool $force = false): mixed
    {
        if ($value === null && ! $force) {
            return $default;
        }

        settype($value, $this->cast);

        return $value;
    }

    protected function castArray(mixed $value, mixed $default, bool $force = false): mixed
    {
        settype($value, $this->cast);

        if (empty($value) && ! $force) {
            return $default;
        }

        return $value;
    }

    protected function castObject(mixed $value, mixed $default, bool $force = false): mixed
    {
        settype($value, $this->cast);

        if (empty(get_object_vars($value)) && ! $force) {
            return $default;
        }

        return $value;
    }

    protected function castClass(mixed $value, mixed $default, bool $force = false): mixed
    {
        if (! class_exists($this->cast)) {
            return $value;
        }

        $classReflection = new ReflectionClass($this->cast);

        if ($classReflection->implementsInterface(CastInterface::class)) {
            $class = resolve($this->cast);

            return $class->cast(value: $value, default: $default);
        }

        return $value;
    }
}
