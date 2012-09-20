<?php

namespace Eluceo\iCal\Component;

use Eluceo\iCal\Component;
use Eluceo\iCal\PropertyBag;

class Event extends Component
{
    protected $uniqueId;

    /**
     * @var \DateTime
     */
    protected $dtStart;

    /**
     * @var \DateTime
     */
    protected $dtEnd;

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
     * @var int
     */
    protected $sequence = 0;

    function __construct($uniqueId = null)
    {
        if (null == $uniqueId) {
            $uniqueId = uniqid();
        }

        $this->uniqueId = $uniqueId;
    }

    public function getType()
    {
        return 'VEVENT';
    }

    public function buildPropertyBag()
    {
        $this->properties = new PropertyBag;

        // mandatory information
        $this->properties->set('UID', $this->uniqueId);
        $this->properties->set('DTSTAMP', $this->getDateString());
        $this->properties->set('DTSTART', $this->dtStart->format($this->getDateFormat($this->noTime)));
        $this->properties->set('DTEND', $this->dtEnd->format($this->getDateFormat($this->noTime)));
        $this->properties->set('SEQUENCE', $this->sequence);

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
    }

    private function getDateFormat($noTime = false)
    {
        return $noTime ? 'Ymd' : 'Ymd\THis';
    }

    private function getDateString($dateTime = null, $noTime = false)
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


}