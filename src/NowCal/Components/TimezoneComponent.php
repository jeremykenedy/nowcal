<?php

namespace NowCal\Components;

use Carbon\CarbonTimeZone;

class TimezoneComponent extends Component
{
    /**
     * The timezone a user is in.
     *
     * @var array
     */
    private $properties = [
        'tzid',
    ];

    /**
     * This property specifies the text value that uniquely identifies the
     * "VTIMEZONE" calendar component in the scope of an iCalendar object.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.3.1
     *
     * @var \Carbon\CarbonTimeZone
     */
    protected $tzid;

    /**
     * Configure the timezone and add it to the class.
     *
     * @param string|null $timezone
     *
     * @return mixed
     */
    public function timezone(?string $tzid = null)
    {
        if (0 === func_num_args()) {
            return $this->get('tzid');
        }

        $this->set('tzid', CarbonTimeZone::create($tzid));

        return $this;
    }

    /**
     * Open the VTimezone tag and add necessary props.
     */
    protected function addTimezone()
    {
        $this->tzid = $this->tzid ?: $this->timezone('UTC');

        $this->output[] = 'BEGIN:VTIMEZONE';
        $this->addStandardTimezoneToOutput();
        $this->addDaylightTimezoneToOutput();
        $this->output[] = 'END:VTIMEZONE';
    }

    protected function addStandardTimezoneToOutput()
    {
        $this->output[] = 'BEGIN:STANDARD';
        $this->output[] = 'TZNAME:'.$this->timezone->getAbbr(false);
        $this->output[] = 'DTSTART:'.$this->castAsDatetime('now');
        $this->output[] = 'TZOFFSETFROM:'.$this->timezone->toOffsetName();
        $this->output[] = 'TZOFFSETTO:'.$this->timezone->toOffsetName();
        $this->output[] = 'END:STANDARD';
    }

    protected function addDaylightTimezoneToOutput()
    {
        $this->output[] = 'BEGIN:DAYLIGHT';
        $this->output[] = 'TZNAME:'.$this->timezone->getAbbr(true);
        $this->output[] = 'DTSTART:'.$this->castAsDatetime('now');
        $this->output[] = 'TZOFFSETFROM:'.$this->timezone->toOffsetName();
        $this->output[] = 'TZOFFSETTO:'.$this->timezone->toOffsetName();
        $this->output[] = 'END:DAYLIGHT';
    }
}
