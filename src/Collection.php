<?php

namespace Keniley\LaravelEntity;

class Collection extends \Illuminate\Support\Collection
{
    protected string $instanceOf;

    /**
     * {@inheritDoc}
     */
    public function __construct($items = [])
    {
        parent::__construct($items); // @see getArrayableItems
    }

    /**
     * {@inheritDoc}
     */
    public function getOrPut($key, $value)
    {
        return parent::getOrPut($key, $value); // @see offsetSet()
    }

    /**
     * {@inheritDoc}
     */
    public function prepend($value, $key = null)
    {
        if (! $value instanceof $this->instanceOf) {
            return $this;
        }

        return parent::prepend($value, $key);
    }

    /**
     * {@inheritDoc}
     */
    public function push(...$values)
    {
        foreach ($values as $value) {
            if ($value instanceof $this->instanceOf) {
                $this->items[] = $value;
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function concat($source)
    {
        return parent::concat($source); // @see push()
    }

    /**
     * {@inheritDoc}
     */
    public function put($key, $value)
    {
        return parent::put($key, $value); // @see offsetSet()
    }

    /**
     * {@inheritDoc}
     */
    public function replace($items)
    {
        return parent::replace($items); // @see getArrayableItems
    }

    /**
     * {@inheritDoc}
     */
    public function replaceRecursive($items)
    {
        return parent::replaceRecursive($items); // @see getArrayableItems
    }

    /**
     * {@inheritDoc}
     */
    public function zip($items)
    {
        throw new \Exception('Function zip() is not implemented');
    }

    /**
     * {@inheritDoc}
     */
    public function pad($size, $value)
    {
        throw new \Exception('Function pad() is not implemented');
    }

    /**
     * {@inheritDoc}
     */
    public function add($item)
    {
        if (! $item instanceof $this->instanceOf) {
            return $this;
        }

        return parent::add($item);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($key, $value): void
    {
        if (! $value instanceof $this->instanceOf) {
            return;
        }

        parent::offsetSet($key, $value);
    }

    /**
     * {@inheritDoc}
     */
    protected function getArrayableItems($items): array
    {
        $items = parent::getArrayableItems($items);

        foreach ($items as $key => $item) {
            if (! $item instanceof $this->instanceOf) {
                unset($items[$key]);
            }
        }

        return $items;
    }
}
