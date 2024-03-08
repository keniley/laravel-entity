<?php

namespace Keniley\LaravelEntity\Traits;

use Keniley\LaravelEntity\Contracts\RepositoryInterface;

trait HasRepository
{
    use HasClassAttributes;

    public static function repository(): ?RepositoryInterface
    {
        /** @var \ReflectionAttribute|null $entityClass */
        $entityClass = static::getClassAttributes(\Keniley\LaravelEntity\Attributes\HasRepository::class)->first();

        return $entityClass?->newInstance()->getRepository();
    }
}
