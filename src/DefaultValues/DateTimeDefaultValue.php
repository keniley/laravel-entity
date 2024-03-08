<?php

namespace Keniley\LaravelEntity\DefaultValues;

use Keniley\LaravelEntity\Contracts\DefaultValueInterface;

final class DateTimeDefaultValue implements DefaultValueInterface
{
    public function get($parameter): \DateTime
    {
        $parameter = empty($parameter) ? 'now' : $parameter;

        $parameter = strtotime($parameter);

        $tz = new \DateTimeZone(config('app.timezone', 'UTC'));

        $date = \DateTime::createFromFormat('U', (string) $parameter);
        $date->setTimezone($tz);

        return $date;
    }
}
