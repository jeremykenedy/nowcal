<?php

namespace NowCal\Components;

trait AlarmComponent
{
    /**
     * The number of alarms that are attached to this invite.
     *
     * @var array
     */
    protected $alarms = [];

    /**
     * The properties that can be added to an alarm tag.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.6.6
     *
     * @var array
     */
    protected $alarm_properties = [
        'action',
        'trigger',
        'duration',
        'repeat',
    ];

    /**
     * Create and attach an alarm .
     *
     * @param array $props
     *
     * @return self
     */
public function alarm(array $props): self
{
    $this->alarms[] = $this->createAlarm($props);

    return $this;
}

    /**
     * Open the VAlarm tag and add necessary props.
     */
    protected function beginAlarm()
    {
        if ($this->hasAlarm()) {
            $this->output[] = 'BEGIN:VALARM';

            $this->addParametersToOutput($this->calendar);
        }
    }

    /**
     * Close the VCalendar tag.
     */
    protected function endAlarm()
    {
        if ($this->hasAlarm()) {
            $this->output[] = 'END:VALARM';
        }
    }

    /

    protected function hasAlarm()
    {
        return count($this->alarms) > 0;
    }

    /**
     * Creates an alarm array.
     *
     * @param array $props
     *
     * @return array
     */
    protected function createAlarm(array $props): array
    {
        return [];
    }
}
