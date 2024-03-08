<?php

namespace Keniley\LaravelEntity\Traits;

trait HasLockedState
{
    protected bool $isLocked = false;

    protected function isLocked(): bool
    {
        return $this->isLocked;
    }

    protected function isUnlocked(): bool
    {
        return ! $this->isLocked();
    }

    protected function lock(): void
    {
        $this->isLocked = true;
    }

    protected function unlock(): void
    {
        $this->isLocked = false;
    }
}
