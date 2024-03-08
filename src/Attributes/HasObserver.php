<?php

namespace Keniley\LaravelEntity\Attributes;

use Keniley\LaravelEntity\Contracts\ObserverInterface;

#[\Attribute]
final readonly class HasObserver
{
    public function __construct(private ?string $observer = null)
    {
    }

    public function hasObserver(): bool
    {
        return ! empty($this->observer);
    }

    public function getObserver(): ?ObserverInterface
    {
        if ($this->hasObserver()) {
            return null;
        }

        $class = resolve($this->observer);

        if ($class instanceof ObserverInterface) {
            return $class;
        }

        return null;
    }
}
