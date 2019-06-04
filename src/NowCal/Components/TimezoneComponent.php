<?php

namespace NowCal\Components;

use Carbon\Carbon;
use Carbon\CarbonTimeZone;

trait TimezoneComponent
{
    /**
     * The timezone a user is in
     *
     * @var string
     */
    protected $timezone;

    /**
     * Configure the timezone and add it to the class
     *
     * @param  null|string  $timezone
     *
     * @return  mixed
     */
    public function timezone(?string $timezone = null)
    {
        if (0 === func_num_args()) {
            return $this->get('tzid');
        }

        $this->set('tzid', CarbonTimeZone::create($timezone));

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
        $this->output[] = 'TZNAME:' . $this->timezone->getAbbr(false);
        $this->output[] = 'DTSTART:' . $this->castAsDatetime('now');
        $this->output[] = 'TZOFFSETFROM:' . $this->timezone->toOffsetName();
        $this->output[] = 'TZOFFSETTO:' . $this->timezone->toOffsetName();
        $this->output[] = 'END:STANDARD';
    }

    protected function addDaylightTimezoneToOutput()
    {
        $this->output[] = 'BEGIN:DAYLIGHT';
        $this->output[] = 'TZNAME:' . $this->timezone->getAbbr(true);
        $this->output[] = 'DTSTART:' . $this->castAsDatetime('now');
        $this->output[] = 'TZOFFSETFROM:' . $this->timezone->toOffsetName();
        $this->output[] = 'TZOFFSETTO:' . $this->timezone->toOffsetName();
        $this->output[] = 'END:DAYLIGHT';
    }
}
