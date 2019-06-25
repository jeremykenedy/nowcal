<?php

namespace NowCal\Components;

class AlarmComponent extends Component
{
    /**
     * The name of the component.
     *
     * @var string
     */
    protected static $name = 'alarm';

    /**
     * The properties that can be added to an alarm tag.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.6.6
     *
     * @var array
     */
    protected static $properties = [
        'action',
        'trigger',
    ];

    protected $action;

    protected $trigger;
}
