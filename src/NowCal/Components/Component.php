<?php

namespace NowCal\Components;

use Illuminate\Support\Str;
use NowCal\Interfaces\ComponentInterface;

abstract class Component implements ComponentInterface
{
    /**
     * The name of the component.
     *
     * @var string
     */
    protected static $name = '';

    /**
     * The properties to output.
     *
     * @var array
     */
    protected static $properties = [];

    /**
     * All the properties that need to be cast.
     *
     * @var array
     */
    protected static $casts = [
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
    protected static $datetime_format = 'Ymd\THis\Z';

    /**
     * The component's output.
     *
     * @var array
     */
    protected $output = [];

    /**
     * Merge the properties supplied with the allowed props.
     *
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $this->merge($properties);
    }

    /**
     * The action to take before output.
     *
     * @return mixed
     */
    public function before()
    {
        return 'BEGIN:V'.Str::upper(self::$name);
    }

    /**
     * The action to take after output.
     *
     * @return mixed
     */
    public function after()
    {
        return 'END:V'.Str::upper(self::$name);
    }

    /**
     * Compile the component's output array.
     *
     * @return mixed
     */
    public function compile()
    {
        $this->output[] = $this->before();
        $this->addPropertiesToOutput();
        $this->output[] = $this->after();
    }

    /**
     * Compile and output component contents.
     *
     * @return array
     */
    public function output(): array
    {
        $this->compile();

        return $this->output;
    }

    /**
     * Get the class' property.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function get(string $key): ?string
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
        return in_array($key, self::$properties);
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
        return array_key_exists($key, self::$casts);
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
            ->format(self::datetime_format);
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

    /**
     * Loop through the component's properties and add it to
     * the output.
     */
    protected function addPropertiesToOutput()
    {
        foreach (self::$properties as $key) {
            if ($this->has($key)) {
                $this->output[] = $this->getProperty($key);
            }
        }
    }

    /**
     * Get the provided property from the ICS spec. If not
     * included in the spec then fail. If not provided but
     * required then throw exception.
     *
     * @param string $key
     *
     * @return string
     */
    protected function getProperty(string $key): string
    {
        return $this->getPropertyKey($key)
            .':'.
            $this->getPropertyValue($key);
    }

    /**
     * Returns the iCalendar param key.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPropertyKey(string $name): string
    {
        return Str::upper($name);
    }

    /**
     * Return the associated value for the supplied iCal param.
     *
     * @param string $key
     *
     * @return string|null
     */
    protected function getPropertyValue(string $key): ?string
    {
        if ($this->hasCaster($key)) {
            return $this->cast($this->{$key}, self::$casts[$key]);
        }

        return $this->{$key};
    }
}
