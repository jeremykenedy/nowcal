<?php

use NowCal\Interfaces\ComponentInterface;
use NowCal\Traits\HasCalendarAttributes;

abstract class Component implements ComponentInterface
{
    use HasCalendarAttributes;

    protected $output = [];

    protected $properties = [];

    protected $wrapOutput = false;

    public function __construct(array $properties)
    {
        $this->merge($properties);
    }

    public function before()
    {
        return '';
    }

    public function output()
    {
        return $this->output;
    }

    public function after()
    {
        return '';
    }

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
     * Get the class' property.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function get(string $key)
    {
        if ($this->allowed($key)) {
            return $this->{$key};
        }

        return null;
    }

    /**
     * Set the class' properties.
     *
     * @param string|array $key
     * @param mixed        $val
     */
    protected function set($key, $val = null)
    {
        if (is_array($key)) {
            $this->merge($key);
        } else {
            if (is_callable($val)) {
                $val = $val();
            }

            if ($this->allowed($key)) {
                $this->{$key} = $val;
            }
        }
    }

    /**
     * Check if the key is allowed to be set.
     *
     * @param string $needle
     * @param string $haystack
     *
     * @return bool
     */
    protected function allowed(string $key): bool
    {
        return in_array($key, $this->properties);
    }

    /**
     * Check if the class has a key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function has(string $key): bool
    {
        return !is_null($this->{$key});
    }

    /**
     * Merge multiple properties.
     *
     * @param array $props
     */
    protected function merge(array $props)
    {
        foreach ($props as $key => $val) {
            $this->set($key, $val);
        }
    }

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
        if (method_exists(self::class, $method = 'castAs'.Str::studly($as))) {
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
