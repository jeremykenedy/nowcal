<?php

namespace NowCal;

abstract class ComponentManager
{
    use Components\EventComponent,
        Components\CalendarComponent;

    /**
     * Gets all the available iCalendar v2 attributes.
     *
     * @return array
     */
    protected function getComponentsAttribute(): array
    {
        return array_merge($this->calendar, $this->event);
    }
}
