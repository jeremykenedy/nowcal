<?php

namespace NowCal\Components;

class TimezoneComponent extends Component
{
    /**
     * The name of the component.
     *
     * @var string
     */
    protected static $name = 'timezone';

    /**
     * The timezone a user is in.
     *
     * @var array
     */
    protected static $properties = [
        'tzid',
        'standard',
        'daylight',
    ];

    /**
     * This property specifies the text value that uniquely identifies the
     * "VTIMEZONE" calendar component in the scope of an iCalendar object.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.3.1
     *
     * @var \Carbon\CarbonTimeZone
     */
    protected $tzid = 'UTC';

    protected $standard;

    protected $daylight;
}
