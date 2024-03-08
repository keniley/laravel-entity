<?php

namespace Keniley\LaravelEntity\Attributes;

use Keniley\LaravelEntity\Contracts\RepositoryInterface;

#[\Attribute]
final readonly class HasRepository
{
    public function __construct(private ?string $repository = null)
    {
    }

    public function hasRepository(): bool
    {
        return ! empty($this->repository);
    }

    public function getRepository(): ?RepositoryInterface
    {
        if (! $this->hasRepository()) {
            return null;
        }

        $class = resolve($this->repository);

        if ($class instanceof RepositoryInterface) {
            return $class;
        }

        return null;
    }
}
