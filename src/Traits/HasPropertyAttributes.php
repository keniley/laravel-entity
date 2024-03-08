<?php

namespace Keniley\LaravelEntity\Traits;

use Illuminate\Support\Collection;
use Keniley\LaravelEntity\Attributes\Property;
use Keniley\LaravelEntity\Support\PropertyInfo;
use Keniley\LaravelEntity\Support\VariableTypeNormalizer;
use ReflectionClass;
use ReflectionProperty;

trait HasPropertyAttributes
{
    protected function getAttributedProperties(): Collection
    {
        $reflectionClass = new ReflectionClass($this);
        $properties = collect($reflectionClass->getProperties());

        return $properties->mapWithKeys(function (ReflectionProperty $property) {
            if ($this->isAttributedProperty(property: $property)) {
                return [$property->getName() => $property];
            }

            return [];
        });
    }

    protected function isAttributedProperty(ReflectionProperty $property): bool
    {
        return ! empty($property->getAttributes(Property::class));
    }

    protected function getAttributeInstance(ReflectionProperty $property): ?Property
    {
        if (! $this->isAttributedProperty(property: $property)) {
            return null;
        }

        return $property->getAttributes(Property::class)[0]->newInstance();
    }

    protected function setValueToProperty(ReflectionProperty $property, mixed $value): void
    {
        // property is not attributed
        if (! $this->isAttributedProperty(property: $property)) {
            return;
        }

        // attribute instance
        $attribute = $this->getAttributeInstance(property: $property);

        // instance is not instance of Property
        if (! $attribute instanceof Property) {
            return;
        }

        // check locked state and protected state
        if ($this->isLocked() && $attribute->isProtected()) {
            return;
        }

        // property definition
        $propertyInfo = new PropertyInfo($property);

        // set default in right type
        $propertyInfo->default = $this->getDefaultValue(property: $property, attribute: $attribute);

        $casting = $attribute->hasOwnCast() ? null : $propertyInfo->type;

        // if property has no custom cast and is mixed - no cast needing
        if ($casting === null && $propertyInfo->type === 'mixed') {
            $property->setValue($this, $value);

            return;
        }

        $value = $attribute->cast(value: $value, default: $propertyInfo->default, cast: $casting);
        $this->setValueToPropertyAfterCasting($property, $propertyInfo, $value);
    }

    protected function setValueToPropertyAfterCasting(ReflectionProperty $property, PropertyInfo $propertyInfo, mixed $value): void
    {
        if ($value === null && $propertyInfo->isNull) {
            $property->setValue($this, $value);

            return;
        }

        if ($propertyInfo->type === 'mixed') {
            $property->setValue($this, $value);

            return;
        }

        $this->checkType($propertyInfo, $value);

        $property->setValue($this, $value);
    }

    protected function getDefaultValue(ReflectionProperty $property, Property $attribute): mixed
    {
        // property definition
        $propertyInfo = new PropertyInfo($property);

        $needCast = true;

        // set custom default value
        if ($attribute->hasDefaultValue()) {
            $propertyInfo->default = $attribute->getDefaultValue();
            $needCast = false;
        }

        // set auto uuid to default value
        if ($attribute->isAutoUuid()) {
            $propertyInfo->default = $attribute->getAutoUuid($property);
            $needCast = false;
        }

        // mixed type is allowed
        if ($propertyInfo->type === 'mixed') {
            return $propertyInfo->default;
        }

        // if null is allowed and default is null
        if ($propertyInfo->isNull && $propertyInfo->default === null) {
            return null;
        }

        if ($needCast) {
            $cast = $attribute->hasOwnCast() ? null : $propertyInfo->type;
            $propertyInfo->default = $attribute->cast(value: $propertyInfo->default, default: $propertyInfo->default, cast: $cast, force: true);
        }

        $this->checkType($propertyInfo, $propertyInfo->default);

        return $propertyInfo->default;
    }

    protected function checkType(PropertyInfo $propertyInfo, mixed $value): void
    {
        $valueType = VariableTypeNormalizer::normalize(gettype($value));

        if ($propertyInfo->isBuildIn) {
            if ($propertyInfo->type !== $valueType) {
                throw new \TypeError('Default value property '.$propertyInfo->name.' is type of '.$valueType.' but property is type of '.$propertyInfo->type);
            }

            return;
        }

        if ($valueType === 'object') {
            if (! $value instanceof $propertyInfo->type) {
                throw new \TypeError('Default value property '.$propertyInfo->name.' is type of '.get_class($value).' but property is type of '.$propertyInfo->type);
            }

            return;
        }

        if ($propertyInfo->type !== $valueType) {
            throw new \TypeError('Default value property '.$propertyInfo->type.' is type of '.$valueType.' but property is type of '.$propertyInfo->type);
        }
    }

    protected function getAllValues(): Collection
    {
        return $this->getAttributedProperties()->mapWithKeys(function (ReflectionProperty $property) {
            $value = $property->isInitialized($this) ? $property->getValue($this) : null;

            return [$property->getName() => $value];
        });
    }
}
