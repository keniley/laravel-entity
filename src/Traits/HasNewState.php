<?php

namespace Keniley\LaravelEntity\Traits;

trait HasNewState
{
    protected bool $isNew = true;

    public function isNew(): bool
    {
        return $this->isNew;
    }

    protected function setNew(bool $isNew): void
    {
        $this->isNew = $isNew;
    }
}
