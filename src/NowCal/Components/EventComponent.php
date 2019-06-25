<?php

namespace NowCal\Components;

use Ramsey\Uuid\Uuid;

class EventComponent extends Component
{
    /**
     * The properties that are allowed to be set on a VEvent.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.6.1
     *
     * @var array
     */
    private $properties = [
        'uid',
        'dtstamp',
        'dtstart',
        'dtend',
        'summary',
        'location',
        'duration',
        'alarm',
    ];

    /**
     * This property defines the persistent, globally unique identifier for the calendar component.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.4.7
     *
     * @var string
     */
    protected $uid;

    /**
     * this property specifies the date and time that the instance of the iCalendar object was created.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.7.2
     *
     * @var string
     */
    protected $dtstamp;

    /**
     * This property specifies when the calendar component begins.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.2.4
     *
     * @var string
     */
    protected $dtstart;

    /**
     * This property specifies the date and time that a calendar
     * component ends.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.2.2
     *
     * @var string
     */
    protected $dtend;

    /**
     * This property defines a short summary or subject for the
     * calendar component.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.1.12
     *
     * @var string
     */
    protected $summary;

    /**
     * This property defines the intended venue for the activity
     * defined by a calendar component.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.1.7
     *
     * @var string
     */
    protected $location;

    /**
     * This property specifies a positive duration of time.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.2.5
     *
     * @var string
     */
    protected $duration;

    /**
     * Create a uid for the event component.
     *
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);

        $this->uid = Uuid::uuid4()->toString();
    }

    /**
     * Set the event's start date.
     *
     * @param mixed $datetime
     *
     * @return mixed
     */
    public function start($datetime = null)
    {
        if (0 === func_num_args()) {
            return $this->get('dtstart');
        }

        $this->set('dtstart', $datetime);

        return $this;
    }

    /**
     * Set the event's end date.
     *
     * @param mixed $datetime
     *
     * @return mixed
     */
    public function end($datetime = null)
    {
        if (0 === func_num_args()) {
            return $this->get('dtend');
        }

        if (!$this->has('duration')) {
            $this->set('dtend', $datetime);
        }

        return $this;
    }

    /**
     * Set the event's summary.
     *
     * @param mixed $summary
     *
     * @return mixed
     */
    public function summary($summary = null)
    {
        if (0 === func_num_args()) {
            return $this->get('summary');
        }

        $this->set('summary', $summary);

        return $this;
    }

    /**
     * Set the event's location.
     *
     * @param mixed $location
     *
     * @return mixed
     */
    public function location($location = null)
    {
        if (0 === func_num_args()) {
            return $this->get('location');
        }

        $this->set('location', $location);

        return $this;
    }

    /**
     * Set the event's duration using a CarbonInterval parsable string.
     *
     * @param mixed $location'
     *
     * @return \NowCal\NowCal
     */
    public function duration($duration = null)
    {
        if (0 === func_num_args()) {
            return $this->get('duration');
        }

        if (!$this->has('dtend')) {
            $this->set('duration', $duration);
        }

        return $this;
    }

    /**
     * Create the VEvent and include all its props.
     */
    protected function before()
    {
        return 'BEGIN:VEVENT';
    }

    public function output()
    {
        return $this->addPropertiesToOutput();
    }

    /**
     * Close the VEvent tag.
     */
    protected function after()
    {
        return 'END:VEVENT';
    }
}
