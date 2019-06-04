<?php

namespace NowCal\Traits;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Str;

trait HasCasters
{
    /**
     * All the properties that need to be cast.
     *
     * @var array
     */
    protected $casts = [
        'duration' => 'duration',
        'created' => 'datetime',
        'dtstamp' => 'datetime',
        'dtstart' => 'datetime',
        'dtend' => 'datetime',
    ];

    /**
     * The format to use for datetimes.
     *
     * @var string
     */
    protected $datetime_format = 'Ymd\THis\Z';

    /**
     * Cast the specified value as the provided type.
     *
     * @param mixed  $value
     * @param string $as
     *
     * @return mixed
     */
    protected function cast($value, string $as)
    {
        if (method_exists(self::class, $method = 'castAs' . Str::studly($as))) {
            return $this->{$method}($value);
        }

        return $value;
    }

    /**
     * Check if the specified key has a caster.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function hasCaster(string $key): bool
    {
        return array_key_exists($key, $this->casts);
    }

    /**
     * Cast the specified value as a datetime.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function castAsDatetime($value): string
    {
        return Carbon::parse($value ?? 'now')
            ->format($this->datetime_format);
    }

    /**
     * Cast the specified value as an ISO 8601.2004 interval.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function castAsDuration($value)
    {
        return CarbonInterval::fromString($value ?? '0s')
            ->spec();
    }
}
