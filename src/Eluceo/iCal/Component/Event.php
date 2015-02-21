<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) Markus Poerschke <markus@eluceo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eluceo\iCal\Component;

use Eluceo\iCal\Component;
use Eluceo\iCal\Property\Event\Attendees;
use Eluceo\iCal\Property;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use Eluceo\iCal\PropertyBag;

/**
 * Implementation of the EVENT component.
 */
class Event extends Component
{
    const TIME_TRANSPARENCY_OPAQUE      = 'OPAQUE';
    const TIME_TRANSPARENCY_TRANSPARENT = 'TRANSPARENT';

    const STATUS_TENTATIVE = 'TENTATIVE';
    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_CANCELLED = 'CANCELLED';

    /**
     * @var string
     */
    protected $uniqueId;

    /**
     * The property indicates the date/time that the instance of
     * the iCalendar object was created.
     *
     * The value MUST be specified in the UTC time format.
     *
     * @var \DateTime
     */
    protected $dtStamp;

    /**
     * @var \DateTime
     */
    protected $dtStart;

    /**
     * Preferentially chosen over the duration if both are set.
     *
     * @var \DateTime
     */
    protected $dtEnd;

    /**
     * @var \DateInterval
     */
    protected $duration;

    /**
     * @var boolean
     */
    protected $noTime = false;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $locationTitle;

    /**
     * @var string
     */
    protected $locationGeo;

    /**
     * @var string
     */
    protected $summary;

    /**
     * @var string
     */
    protected $organizer;

    /**
     * @see http://www.ietf.org/rfc/rfc2445.txt 4.8.2.7 Time Transparency
     *
     * @var string
     */
    protected $transparency = self::TIME_TRANSPARENCY_OPAQUE;

    /**
     * If set to true the timezone will be added to the event.
     *
     * @var bool
     */
    protected $useTimezone = false;

    /**
     * @var int
     */
    protected $sequence = 0;

    /**
     * @var Attendees
     */
    protected $attendees;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var RecurrenceRule
     */
    protected $recurrenceRule;

    /**
     * This property specifies the date and time that the calendar
     * information was created.
     *
     * The value MUST be specified in the UTC time format.
     *
     * @var \DateTime
     */
    protected $created;

    /**
     * The property specifies the date and time that the information
     * associated with the calendar component was last revised.
     *
     * The value MUST be specified in the UTC time format.
     *
     * @var \DateTime
     */
    protected $modified;

    /**
     * Indicates if the UTC time should be used or not.
     *
     * @var bool
     */
    protected $useUtc = true;

    /**
     * @var bool
     */
    protected $cancelled;

    /**
     * This property is used to specify categories or subtypes
     * of the calendar component.  The categories are useful in searching
     * for a calendar component of a particular type and category.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.1.2
     *
     * @var array
     */
    protected $categories;

    public function __construct($uniqueId = null)
    {
        if (null == $uniqueId) {
            $uniqueId = uniqid();
        }

        $this->uniqueId = $uniqueId;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'VEVENT';
    }

    /**
     * {@inheritdoc}
     */
    public function buildPropertyBag()
    {
        $this->properties = new PropertyBag();

        // mandatory information
        $this->properties->set('UID', $this->uniqueId);

        $this->properties->add($this->buildDateTimeProperty('DTSTART', $this->dtStart, $this->noTime));
        $this->properties->set('SEQUENCE', $this->sequence);
        $this->properties->set('TRANSP', $this->transparency);

        if ($this->status) {
            $this->properties->set('STATUS', $this->status);
        }

        // An event can have a 'dtend' or 'duration', but not both.
        if (null != $this->dtEnd) {
            $this->properties->add($this->buildDateTimeProperty('DTEND', $this->dtEnd, $this->noTime));
        } elseif (null != $this->duration) {
            $this->properties->set('DURATION', $this->duration->format('P%dDT%hH%iM%sS'));
        }

        // optional information
        if (null != $this->url) {
            $this->properties->set('URL', $this->url);
        }

        if (null != $this->location) {
            $this->properties->set('LOCATION', $this->location);

            if (null != $this->locationGeo) {
                $this->properties->add(
                    new Property(
                        'X-APPLE-STRUCTURED-LOCATION',
                        'geo:' . $this->locationGeo,
                        array(
                            'VALUE'          => 'URI',
                            'X-ADDRESS'      => $this->location,
                            'X-APPLE-RADIUS' => 49,
                            'X-TITLE'        => $this->locationTitle,
                        )
                    )
                );
            }
        }

        if (null != $this->summary) {
            $this->properties->set('SUMMARY', $this->summary);
        }

        if (null != $this->attendees) {
            $this->properties->add($this->attendees);
        }

        if (null != $this->description) {
            $this->properties->set('DESCRIPTION', $this->description);
        }

        if (null != $this->recurrenceRule) {
            $this->properties->set('RRULE', $this->recurrenceRule);
        }

        if ($this->cancelled) {
            $this->properties->set('STATUS', 'CANCELLED');
        }

        if (null != $this->organizer) {
            $this->properties->set('ORGANIZER', $this->organizer);
        }

        if ($this->noTime) {
            $this->properties->set('X-MICROSOFT-CDO-ALLDAYEVENT', 'TRUE');
        }

        if (null != $this->categories) {
            $this->properties->set('CATEGORIES', $this->categories);
        }

        // remember custom settings before we enforce a specific value
        $customUseTZ        = $this->useTimezone;
        $customUseUTC       = $this->useUtc;

        // the following properties need to be set in UTC so we enforce that
        $this->useTimezone  = false;
        $this->useUtc       = true;

        $this->properties->add(
            $this->buildDateTimeProperty('DTSTAMP', $this->dtStamp ?: new \DateTime())
        );

        if ($this->created) {
            $this->properties->add($this->buildDateTimeProperty('CREATED', $this->created));
        }

        if ($this->modified) {
            $this->properties->add($this->buildDateTimeProperty('LAST-MODIFIED', $this->modified));
        }

        // reset the custom values
        $this->useTimezone  = $customUseTZ;
        $this->useUtc       = $customUseUTC;
    }

    /**
     * Creates a Property based on a DateTime object.
     *
     * @param string    $name     The name of the Property
     * @param \DateTime $dateTime The DateTime
     * @param bool      $noTime   Indicates if the time will be added
     *
     * @return \Eluceo\iCal\Property
     */
    protected function buildDateTimeProperty($name, \DateTime $dateTime, $noTime = false)
    {
        $dateString = $this->getDateString($dateTime, $noTime);
        $params     = array();

        if ($this->useTimezone) {
            $timeZone       = $dateTime->getTimezone()->getName();
            $params['TZID'] = $timeZone;
        }

        if ($noTime) {
            $params['VALUE'] = 'DATE';
        }

        return new Property($name, $dateString, $params);
    }

    /**
     * Returns the date format that can be passed to DateTime::format().
     *
     * @param bool $noTime Indicates if the time will be added
     *
     * @return string
     */
    protected function getDateFormat($noTime = false)
    {
        // Do not use UTC time (Z) if timezone support is enabled.
        if ($this->useTimezone || !$this->useUtc) {
            return $noTime ? 'Ymd' : 'Ymd\THis';
        } else {
            return $noTime ? 'Ymd' : 'Ymd\THis\Z';
        }
    }

    /**
     * Returns a formatted date string.
     *
     * @param \DateTime|null $dateTime The DateTime object
     * @param bool           $noTime   Indicates if the time will be added
     *
     * @return mixed
     */
    protected function getDateString(\DateTime $dateTime = null, $noTime = false)
    {
        if (empty($dateTime)) {
            $dateTime = new \DateTime();
        }

        return $dateTime->format($this->getDateFormat($noTime));
    }

    /**
     * @param $dtEnd
     *
     * @return $this
     */
    public function setDtEnd($dtEnd)
    {
        $this->dtEnd = $dtEnd;

        return $this;
    }

    public function getDtEnd()
    {
        return $this->dtEnd;
    }

    public function setDtStart($dtStart)
    {
        $this->dtStart = $dtStart;

        return $this;
    }

    /**
     * @param $dtStamp
     *
     * @return $this
     */
    public function setDtStamp($dtStamp)
    {
        $this->dtStamp = $dtStamp;

        return $this;
    }

    /**
     * @param $duration
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @param        $location
     * @param string $title
     * @param null   $geo
     *
     * @return $this
     */
    public function setLocation($location, $title = '', $geo = null)
    {
        $this->location      = $location;
        $this->locationTitle = $title;
        $this->locationGeo   = $geo;

        return $this;
    }

    /**
     * @param $noTime
     *
     * @return $this
     */
    public function setNoTime($noTime)
    {
        $this->noTime = $noTime;

        return $this;
    }

    /**
     * @param $sequence
     *
     * @return $this
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * @param $organizer
     *
     * @return $this
     */
    public function setOrganizer($organizer)
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * @param $summary
     *
     * @return $this
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @param $uniqueId
     *
     * @return $this
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @param $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param $useTimezone
     *
     * @return $this
     */
    public function setUseTimezone($useTimezone)
    {
        $this->useTimezone = $useTimezone;

        return $this;
    }

    /**
     * @return bool
     */
    public function getUseTimezone()
    {
        return $this->useTimezone;
    }

    /**
     * @param $attendees
     *
     * @return $this
     */
    public function setAttendees($attendees)
    {
        $this->attendees = $attendees;

        return $this;
    }

    /**
     * @param string $attendee
     * @param array  $params
     *
     * @return $this
     */
    public function addAttendee($attendee, $params = array())
    {
        if (!isset($this->attendees)) {
            $this->attendees = new Attendees();
        }
        $this->attendees->add($attendee, $params);

        return $this;
    }

    /**
     * @return string
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param bool $useUtc
     *
     * @return $this
     */
    public function setUseUtc($useUtc = true)
    {
        $this->useUtc = $useUtc;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $status
     *
     * @return $this
     */
    public function setCancelled($status)
    {
        $this->cancelled = (bool) $status;

        return $this;
    }

    /**
     * @param $transparency
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setTimeTransparency($transparency)
    {
        $transparency = strtoupper($transparency);
        if ($transparency === self::TIME_TRANSPARENCY_OPAQUE
            || $transparency === self::TIME_TRANSPARENCY_TRANSPARENT
        ) {
            $this->transparency = $transparency;
        } else {
            throw new \InvalidArgumentException('Invalid value for transparancy');
        }

        return $this;
    }

    /**
     * @param $status
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setStatus($status)
    {
        $status = strtoupper($status);
        if ($status == self::STATUS_CANCELLED
            || $status == self::STATUS_CONFIRMED
            || $status == self::STATUS_TENTATIVE
        ) {
            $this->status = $status;
        } else {
            throw new \InvalidArgumentException('Invalid value for status');
        }

        return $this;
    }

    /**
     * @param RecurrenceRule $recurrenceRule
     *
     * @return $this
     */
    public function setRecurrenceRule(RecurrenceRule $recurrenceRule)
    {
        $this->recurrenceRule = $recurrenceRule;

        return $this;
    }

    /**
     * @return RecurrenceRule
     */
    public function getRecurrenceRule()
    {
        return $this->recurrenceRule;
    }

    /**
     * @param $dtStamp
     *
     * @return $this
     */
    public function setCreated($dtStamp)
    {
        $this->created = $dtStamp;

        return $this;
    }

    /**
     * @param $dtStamp
     *
     * @return $this
     */
    public function setModified($dtStamp)
    {
        $this->modified = $dtStamp;

        return $this;
    }

    /**
     * @param $categories
     *
     * @return $this
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }
}
