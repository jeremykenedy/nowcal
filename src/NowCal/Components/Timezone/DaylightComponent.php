<?php

namespace NowCal\Components\Timezone;

use NowCal\Components\Component;

class DaylightComponent extends Component
{
    /**
     * The name of the component.
     *
     * @var string
     */
    protected static $name = 'daylight';

    /**
     * The timezone a user is in.
     *
     * @var array
     */
    protected static $properties = [
        'tzname',
        'dtstart',
        'tzoffsetfrom',
        'tzoffsetto',
    ];
}
