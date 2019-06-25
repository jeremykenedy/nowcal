<?php

namespace NowCal\Components;

class CalendarComponent extends Component
{
    /**
     * The name of the component.
     *
     * @var string
     */
    protected static $name = 'calendar';

    /**
     * The required fields for the VCalendar.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.4
     *
     * @var array
     */
    protected static $properties = [
        'prodid',
        'version',
    ];

    /**
     * iCalendar Product Identifier.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.7.3
     *
     * @var string
     */
    protected $prodid = '-//itsnubix//NowCal//EN';

    /**
     * Specifies the minimum iCalendar specification that is required
     * in order to interpret the iCalendar object.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.7.4
     *
     * @var string
     */
    protected $version = '2.0';
}
