<?php

namespace NowCal\Components;

class CalendarComponent extends Component
{
    /**
     * The required fields for the VCalendar.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.4
     *
     * @var array
     */
    private $properties = [
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

    /**
     * Open the VCalendar tag and add necessary props.
     */
    public function before()
    {
        return 'BEGIN:VCALENDAR';
    }

    public function output()
    {
        return $this->addParametersToOutput($this->properties);
    }

    /**
     * Close the VCalendar tag.
     */
    public function after()
    {
        return 'END:VCALENDAR';
    }
}
