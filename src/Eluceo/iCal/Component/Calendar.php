<?php

namespace Eluceo\iCal\Component;

use Eluceo\iCal\Component;
use Eluceo\iCal\PropertyBag;

class Calendar extends Component
{
    protected $prodId = null;

    function __construct($prodId)
    {
        if (empty($prodId)) {
            throw new \UnexpectedValueException('PRODID cannot be empty');
        }

        $this->prodId = $prodId;
    }

    public function getType()
    {
        return 'VCALENDAR';
    }

    public function buildPropertyBag()
    {
        $this->properties = new PropertyBag;
        $this->properties->set('VERSION', '2.0');
        $this->properties->set('PRODID', $this->prodId);
    }

    public function addEvent(Event $event)
    {
        $this->addComponent($event);
    }

    public function getProdId()
    {
        return $this->prodId;
    }
}