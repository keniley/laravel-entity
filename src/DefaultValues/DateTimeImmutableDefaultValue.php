<?php

namespace Keniley\LaravelEntity\DefaultValues;

use Keniley\LaravelEntity\Contracts\DefaultValueInterface;

final class DateTimeImmutableDefaultValue implements DefaultValueInterface
{
    public function get($parameter): \DateTimeImmutable
    {
        $parameter = empty($parameter) ? 'now' : $parameter;

        $parameter = strtotime($parameter);

        $tz = new \DateTimeZone(config('app.timezone', 'UTC'));

        $date = \DateTimeImmutable::createFromFormat('U', (string) $parameter);

        return $date->setTimezone($tz);
    }
}
