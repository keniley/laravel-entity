<?php

namespace Keniley\LaravelEntity\Traits;

use Illuminate\Support\Collection;

trait HasDirtyWatcher
{
    protected Collection $original;

    protected bool $originalAlreadySaved = false;

    protected function takeOriginal(bool $force = true): void
    {
        if ($force) {
            $this->original = $this->getAllValues();
            $this->originalAlreadySaved = true;

            return;
        }

        if (! $this->originalAlreadySaved) {
            $this->original = $this->getAllValues();
            $this->originalAlreadySaved = true;
        }
    }

    public function isDirty(?string $property = null): bool
    {
        return empty($property) ? $this->getDirty()->isNotEmpty() : $this->getDirty(property: $property) !== null;
    }

    public function getDirty(?string $property = null): mixed
    {
        $all = $this->getAllValues()->mapWithKeys(function (mixed $value, string $key) {
            return $value === $this->original->get($key) ? [] : [$key => $value];
        });

        return empty($property) ? $all : $all->get($property);
    }

    abstract protected function getAllValues(): Collection;
}
