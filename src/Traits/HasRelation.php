<?php

namespace Keniley\LaravelEntity\Traits;

use Illuminate\Support\Collection;

trait HasRelation
{
    protected Collection $loaded;

    protected function register(): void
    {
        $this->loaded = new Collection();
    }

    public function isRelationLoaded(string $propertyName): bool
    {
        return $this->loaded->has($propertyName) && $this->loaded->get($propertyName) === true;
    }

    public function setRelationState(string $propertyName, bool $state): void
    {
        if ($state) {
            $this->loaded->put($propertyName, true);

            return;
        }

        $this->loaded->forget($propertyName);
    }
}
