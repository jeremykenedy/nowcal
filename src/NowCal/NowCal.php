<?php

namespace NowCal;

use Illuminate\Support\Str;
use NowCal\Components\AlarmComponent;
use NowCal\Components\EventComponent;
use NowCal\Components\CalendarComponent;
use NowCal\Components\TimezoneComponent;

class NowCal
{
    /**
     * The line end to use.
     *
     * @var string
     */
    protected static $crlf = '\r\n';

    /**
     * The .ics array details.
     *
     * @var array
     */
    protected $output = [];

    /**
     * The alarm for the invite.
     *
     * @var \NowCal\Components\AlarmComponent
     */
    protected $alarm;

    /**
     * The alarm for the invite.
     *
     * @var \NowCal\Components\CalendarComponent
     */
    protected $calendar;

    /**
     * The event component for the invite.
     *
     * @var \NowCal\Components\EventComponent
     */
    protected $event;

    /**
     * The timezone component for the invite.
     *
     * @var \NowCal\Components\TimezoneComponent
     */
    protected $timezone;

    /**
     * Instantiate the NowCal class.
     *
     * @param array $params
     */
    public function __construct(array $properties = [])
    {
        $this->calendar = new CalendarComponent($properties);
        $this->alarm = new AlarmComponent($properties);
        $this->timezone = new TimezoneComponent($properties);
        $this->event = new EventComponent($properties);
    }

    /**
     * Fetch computed properties.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        if (method_exists(self::class, $method = 'get'.Str::studly($key).'Attribute')) {
            return $this->{$method}();
        }

        return null;
    }

    /**
     * Spits out the plain text event.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->plain;
    }

    /**
     * Pass the props into the class and create a new instance.
     *
     * @param array $props
     *
     * @return \NowCal\NowCal
     */
    public static function create(array $props = [])
    {
        return new self($props);
    }

    /**
     * Create an ICS array and output as raw array.
     *
     * @param array $props
     *
     * @return array
     */
    public static function raw(array $props = []): array
    {
        return self::create($props)->raw;
    }

    /**
     * Return the plain text version of the invite.
     *
     * @param array $props
     *
     * @return string
     */
    public static function plain(array $props = []): string
    {
        return self::create($props)->plain;
    }

    /**
     * Return a path to a .ics tempfile.
     *
     * @param array $props
     *
     * @return string
     */
    public static function file(array $props = []): string
    {
        return self::create($props)->file;
    }

    /**
     * Compile the event's raw output.
     *
     * @return \NowCal\NowCal
     */
    protected function compile()
    {
        $this->output = [];

        $this->output[] = $this->calendar()->before();
        $this->output[] = $this->timezone()->output;
        $this->output[] = $this->alarm()->output;
        $this->output[] = $this->event()->output;
        $this->output[] = $this->calendar()->after();

        echo var_dump($this->output);

        return $this;
    }

    /**
     * Return the invite's raw output array.
     *
     * @return array
     */
    public function getRawAttribute(): array
    {
        return $this->compile()->output;
    }

    /**
     * Return the invite's data as plain text.
     *
     * @return string
     */
    public function getPlainAttribute(): string
    {
        return implode(self::$crlf, $this->output);
    }

    /**
     * Creates a tempfile and returns its path.
     *
     * @return string
     */
    public function getFileAttribute(): string
    {
        $filename = tempnam(sys_get_temp_dir(), 'event_').'.ic s ';
        file_put_contents($filename, $this->plain.'\r\n');

        return $filename;
    }

    public function alarm(?array $props = [])
    {
        if (0 === func_num_args()) {
            return $this->alarm;
        }

        $this->alarm = new AlarmComponent($props);

        return $this;
    }

    public function event(?array $props = [])
    {
        if (0 === func_num_args()) {
            return $this->event;
        }

        $this->event = new EventComponent($props);

        return $this;
    }

    public function calendar(?array $props = [])
    {
        if (0 === func_num_args()) {
            return $this->calendar;
        }

        $this->calendar = new CalendarComponent($props);

        return $this;
    }

    public function timezone(?array $props = [])
    {
        if (0 === func_num_args()) {
            return $this->timezone;
        }

        $this->timezone = new TimezoneComponent($props);

        return $this;
    }
}
