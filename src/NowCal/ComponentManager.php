<?php

namespace NowCal;

abstract class ComponentManager
{
    use Components\AlarmComponent,
        Components\EventComponent,
        Components\CalendarComponent;

    /**
     * Gets all the available iCalendar v2 attributes.
     *
     * @return array
     */
    protected function getPropertiesAttribute(): array
    {
        return array_merge(
            $this->calendar_properties,
            $this->event_properties,
            $this->alarm_properties
        );
    }
}
