<?php

namespace NowCal\Components\Timezone;

use NowCal\Components\Component;

class StandardComponent extends Component
{
    /**
     * The name of the component.
     *
     * @var string
     */
    protected static $name = 'standard';

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
