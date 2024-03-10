<?php

namespace Keniley\LaravelEntity;

use AllowDynamicProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use JsonSerializable;
use Keniley\LaravelEntity\Attributes\Property;
use Keniley\LaravelEntity\Enums\EntityEvent;
use Keniley\LaravelEntity\Traits\HasDirtyWatcher;
use Keniley\LaravelEntity\Traits\HasEvents;
use Keniley\LaravelEntity\Traits\HasLockedState;
use Keniley\LaravelEntity\Traits\HasNewState;
use Keniley\LaravelEntity\Traits\HasOwnCollection;
use Keniley\LaravelEntity\Traits\HasPropertyAttributes;
use Keniley\LaravelEntity\Traits\HasRepository;
use ReflectionClass;
use ReflectionProperty;

#[AllowDynamicProperties]
class Entity implements Arrayable, JsonSerializable
{
    use HasDirtyWatcher;
    use HasEvents;
    use HasLockedState;
    use HasNewState;
    use HasOwnCollection;
    use HasPropertyAttributes;
    use HasRepository;

    public function __construct()
    {
        $this->register();
        $this->boot();
        $this->takeOriginal();
    }

    /**
     * @throws \ReflectionException
     */
    protected function register(): void
    {
        $reflectionClass = new ReflectionClass($this);
        $traits = $reflectionClass->getTraits();

        foreach ($traits as $trait) {
            if ($trait->hasMethod('register')) {
                $method = $trait->getMethod('register');
                $method->invoke($this);
            }
        }
    }

    public function __get(string $name): mixed
    {
        return $this->get(name: $name);
    }

    public function __set(string $name, mixed $value): void
    {
        $this->set(name: $name, value: $value);
    }

    protected function boot(array $raw = []): void
    {
        foreach ($this->getAttributedProperties() as $property) {
            $value = $raw[$property->getName()] ?? null;
            $this->setValueToProperty(property: $property, value: $value);
        }
    }

    public function get(string $name): mixed
    {
        /** @var ReflectionProperty|null $property */
        $property = $this->getAttributedProperties()->get($name);

        if (! $property instanceof ReflectionProperty) {
            return null;
        }

        if ($property->isInitialized($this)) {
            return $property->getValue($this);
        }

        return null;
    }

    public function set(string $name, mixed $value): void
    {
        $property = $this->getAttributedProperties()->get($name);

        if ($property instanceof ReflectionProperty) {
            $this->setValueToProperty(property: $property, value: $value);
        }
    }

    public function fill(array $raw): void
    {
        $this->takeOriginal(force: false);
        $this->boot(raw: $raw);
    }

    public function fromSource(array $raw): void
    {
        $this->boot(raw: $raw);
        $this->takeOriginal();
        $this->setNew(false);
        $this->lock();
        $this->fireEvent(event: EntityEvent::RETRIEVED);
    }

    public function values(): Collection
    {
        return $this->getAttributedProperties()->mapWithKeys(function (ReflectionProperty $property) {
            $attribute = $this->getAttributeInstance($property);

            if (! $attribute instanceof Property || $attribute->isHidden()) {
                return [];
            }

            $value = $property->isInitialized($this) ? $property->getValue($this) : null;

            return [$property->getName() => $value];
        });
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return $this->values()->toArray();
    }
}
