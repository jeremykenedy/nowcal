<?php

namespace NowCal\Components;

use Ramsey\Uuid\Uuid;

trait EventComponent
{
    /**
     * The properties that are allowed to be set on a VEvent.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.6.1
     *
     * @var array
     */
    protected $event_properties = [
        'uid',
        'dtstamp',
        'start',
        'end',
        'summary',
        'location',
        'duration',
        'alarm',
    ];

    /**
     * CRLF return.
     *
     * @var string
     */
    protected static $crlf = "\r\n";

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
    protected $start;

    /**
     * This property specifies the date and time that a calendar
     * component ends.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.2.2
     *
     * @var string
     */
    protected $end;

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
     * Set the event's start date.
     *
     * @param mixed $datetime
     *
     * @return mixed
     */
    public function start($datetime = null)
    {
        if (0 === func_num_args()) {
            return $this->get('start');
        }

        $this->set('start', $datetime);

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
            return $this->get('end');
        }

        if (!$this->has('duration')) {
            $this->set('end', $datetime);
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

        if (!$this->has('end')) {
            $this->set('duration', $duration);
        }

        return $this;
    }

    /**
     * Set the UID parameter.
     */
    public function setUidParameter()
    {
        return $this->uid ?: $this->uid = Uuid::uuid4()->toString();
    }

    /**
     * Set the DTStamp parameter.
     */
    public function setDtstampParameter()
    {
        return $this->dtstamp ?: $this->dtstamp = 'now';
    }

    /**
     * Create the VEvent and include all its props.
     */
    protected function beginEvent()
    {
        $this->setUidParameter();
        $this->setDtstampParameter();

        $this->output[] = 'BEGIN:VEVENT';

        $this->addParametersToOutput($this->event_properties);
    }

    /**
     * Close the VEvent tag.
     */
    protected function endEvent()
    {
        $this->output[] = 'END:VEVENT';
    }
}
