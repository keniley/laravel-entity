<?php

namespace Keniley\LaravelEntity\Traits;

use Keniley\LaravelEntity\Attributes\HasObserver;
use Keniley\LaravelEntity\Contracts\ObserverInterface;
use Keniley\LaravelEntity\Enums\EntityEvent;

trait HasEvents
{
    use HasClassAttributes;

    public function fireEvent(EntityEvent $event): bool
    {
        $observer = $this->observer();

        $result = null;

        if ($observer instanceof ObserverInterface) {
            $method = $event->value;
            if (method_exists($observer, $method)) {
                $result = $observer->$method($this);
            }
        }

        if (is_bool($result)) {
            return $result;
        }

        return true;
    }

    public static function observer(): ?ObserverInterface
    {
        /** @var \ReflectionAttribute|null $entityClass */
        $entityClass = static::getClassAttributes(HasObserver::class)->first();

        return $entityClass?->newInstance()->getObserver();
    }
}
