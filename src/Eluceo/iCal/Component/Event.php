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
use Eluceo\iCal\PropertyBag;
use Eluceo\iCal\Property;
use \InvalidArgumentException;

/**
 * Implementation of the EVENT component
 */
class Event extends Component
{

    const TIME_TRANSPARENCY_OPAQUE = 'OPAQUE';
    const TIME_TRANSPARENCY_TRANSPARENT = 'TRANSPARENT';

    /**
     * @var string
     */
    protected $uniqueId;

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
    protected $summary;

    /**
     * @see http://www.ietf.org/rfc/rfc2445.txt 4.8.2.7 Time Transparency
     * @var string
     */
    protected $transparency = self::TIME_TRANSPARENCY_OPAQUE;

    /**
     * If set to true the timezone will be added to the event
     *
     * @var bool
     */
    protected $useTimezone = false;

    /**
     * @var int
     */
    protected $sequence = 0;

    /**
     * @var string
     */
    protected $attendee;

    /**
     * @var string
     */
    protected $description;

    /**
     * Indicates if the UTC time should be used or not
     *
     * @var bool
     */
    protected $useUtc = true;

    function __construct($uniqueId = null)
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
        $this->properties = new PropertyBag;

        // mandatory information
        $this->properties->set('UID', $this->uniqueId);
        $this->properties->add($this->buildDateTimeProperty('DTSTAMP', new \DateTime()));
        $this->properties->add($this->buildDateTimeProperty('DTSTART', $this->dtStart, $this->noTime));
        $this->properties->set('SEQUENCE', $this->sequence);
        $this->properties->set('TRANSP', $this->transparency);

        // An event can have a 'dtend' or 'duration', but not both.
        if (null != $this->dtEnd) {
            $this->properties->add($this->buildDateTimeProperty('DTEND', $this->dtEnd, $this->noTime));
        }
        else {
            $this->properties->set('DURATION', $this->duration->format('P%dDT%hH%iM%sS'));
        }

        // optional information
        if (null != $this->url) {
            $this->properties->set('URL', $this->url);
        }

        if (null != $this->location) {
            $this->properties->set('LOCATION', $this->location);
        }

        if (null != $this->summary) {
            $this->properties->set('SUMMARY', $this->summary);
        }

        if (null != $this->attendee) {
            $this->properties->set('ATTENDEE', $this->attendee);
        }

        if (null != $this->description) {
            $this->properties->set('DESCRIPTION', $this->description);
        }
        
        if( $this->noTime )
            $this->properties->set('X-MICROSOFT-CDO-ALLDAYEVENT', 'TRUE');
    }

    /**
     * Creates a Property based on a DateTime object
     *
     * @param string        $name       The name of the Property
     * @param \DateTime     $dateTime   The DateTime
     * @param bool          $noTime     Indicates if the time will be added
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
        
        if( $noTime )
            $params['VALUE'] = 'DATE';

        return new Property($name, $dateString, $params);
    }

    /**
     * Returns the date format that can be passed to DateTime::format()
     *
     * @param bool $noTime Indicates if the time will be added
     * @return string
     */
    protected function getDateFormat($noTime = false)
    {
        // Do not use UTC time (Z) if timezone support is enabled.
        if ($this->useTimezone || !$this->useUtc) {
            return $noTime ? 'Ymd' : 'Ymd\THis';
        }
        else {
            return $noTime ? 'Ymd' : 'Ymd\THis\Z';
        }
    }

    /**
     * Returns a formatted date string
     *
     * @param \DateTime|null  $dateTime  The DateTime object
     * @param bool            $noTime    Indicates if the time will be added
     * @return mixed
     */
    protected function getDateString(\DateTime $dateTime = null, $noTime = false)
    {
        if (empty($dateTime)) {
            $dateTime = new \DateTime();
        }

        return $dateTime->format($this->getDateFormat($noTime));
    }

    public function setDtEnd($dtEnd)
    {
        $this->dtEnd = $dtEnd;
    }

    public function setDtStart($dtStart)
    {
        $this->dtStart = $dtStart;
    }
    
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setNoTime($noTime)
    {
        $this->noTime = $noTime;
    }

    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setUseTimezone($useTimezone)
    {
        $this->useTimezone = $useTimezone;
    }

    public function getUseTimezone()
    {
        return $this->useTimezone;
    }

    /**
     * @param string $description
     */
    public function setAttendee($attendee)
    {
        $this->attendee = $attendee;
    }

    /**
     * @return string
     */
    public function getAttendee()
    {
        return $this->attendee;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setUseUtc($useUtc = true) {
        $this->useUtc = $useUtc;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function setTimeTransparency($transparency)
    {
        $transparency = strtoupper($transparency);
        if ($transparency === self::TIME_TRANSPARENCY_OPAQUE ||
            $transparency === self::TIME_TRANSPARENCY_TRANSPARENT) {
            $this->transparency = $transparency;
        } else {
            throw new InvalidArgumentException('Invalid value for transparancy');
        }
    }
}
