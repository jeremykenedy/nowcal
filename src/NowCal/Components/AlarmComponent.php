<?php

namespace NowCal\Components;

use Ramsey\Uuid\Uuid;

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
        'trigger'
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
        $this->alarms[] = $this->createAlarm($props);

        return $this;
    }

    /**
     * Build the alarm for output
     *
     * @param   array  $alarm
     */
    protected function addAlarmToOutput(array $alarm)
    {
        $this->output[] = 'BEGIN:VALARM';
        $this->addParametersToOutput($alarm);
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
        $alarm = [
            'uid' => Uuid::uuid4()->toString()
        ];

        foreach ($this->alarm_properties as $key) {
            if (array_key_exists($key, $props)) {
                $alarm[$key] = $props[$key];
            }
        }

        return $alarm;
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
}
