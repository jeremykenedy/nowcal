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
        'repeat',
        'trigger',
        'duration',
    ];

    /**
     * Create and attach an alarm to the instance.
     *
     * @param array $props
     *
     * @return self
     */
    public function alarm(array $props): self
    {
        if ($this->alarmIsValid($props)) {
            $this->alarms[] = $this->createAlarm($props);
        }

        return $this;
    }

    protected function addAlarmToOutput(array $alarm)
    {
        $this->output[] = 'BEGIN:VALARM';

        $this->output[] = 'END:VALARM';
    }

    /**
     * Open the VAlarm tag and add necessary props.
     */
    protected function addAlarms()
    {
        if ($this->hasAlarms()) {
            foreach ($this->alarms as $alarm) {
                $this->addAlarmToOutput($alarm);
            }
        }
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

    /**
     * Check if there are any alarms on this invite instance.
     *
     * @return bool
     */
    protected function hasAlarms(): bool
    {
        return count($this->alarms) > 0;
    }

    /**
     * Check to ensure the alarm properties are valid and
     * contain the required information.
     *
     * @param array $props
     *
     * @return array
     */
    protected function alarmIsValid(array $alarm): bool
    {
        return false;
    }
}
