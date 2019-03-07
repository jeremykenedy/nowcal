<?php

namespace NowCal\Components;

trait CalendarComponent
{
    /**
     * The required fields for the VCalendar.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.4
     *
     * @var array
     */
    protected $calendar_properties = [
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
    protected function beginCalendar()
    {
        $this->output[] = 'BEGIN:VCALENDAR';

        $this->addParametersToOutput($this->calendar);
    }

    /**
     * Close the VCalendar tag.
     */
    protected function endCalendar()
    {
        $this->output[] = 'END:VCALENDAR';
    }
}
