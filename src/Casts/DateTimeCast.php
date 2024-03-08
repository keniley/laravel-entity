<?php

namespace Keniley\LaravelEntity\Casts;

use Keniley\LaravelEntity\Contracts\CastInterface;

final class DateTimeCast implements CastInterface
{
    public function cast(mixed $value, mixed $default): mixed
    {
        if ($value instanceof \DateTime) {
            return $value;
        }

        if ($value instanceof \DateTimeImmutable) {
            return $this->fromDateTimeImmutable($value, $default);
        }

        if (empty($value)) {
            return $default;
        }

        $value = strtotime($value);

        if ($value === false) {
            return $default;
        }

        try {
            $tz = new \DateTimeZone(config('app.timezone'));

            return new \DateTime('@'.$value, $tz);
        } catch (\Exception $exception) {
            return $default;
        }
    }

    protected function fromDateTimeImmutable(\DateTimeImmutable $value, mixed $default): mixed
    {
        try {
            $tz = new \DateTimeZone(config('app.timezone'));

            return new \DateTime('@'.$value->format('U'), $tz);
        } catch (\Exception $exception) {
            return $default;
        }
    }
}
