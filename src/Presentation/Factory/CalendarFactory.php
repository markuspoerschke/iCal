<?php

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\Entity\Calendar as CalendarEntity;
use Eluceo\iCal\Presentation\Calendar;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;

class CalendarFactory
{
    private EventFactory $eventFactory;

    public function __construct(?EventFactory $eventFactory = null)
    {
        $this->eventFactory = $eventFactory ?? new EventFactory();
    }

    public function createCalendar(CalendarEntity $calendar): Calendar
    {
        $components = [];
        foreach ($calendar->getEvents() as $event) {
            $components[] = $this->eventFactory->createComponent($event);
        }

        $properties = [
            Property::create('PRODID', StringValue::fromString($calendar->getProductIdentifier())),
            Property::create('VERSION', StringValue::fromString('2.0')),
        ];

        return Calendar::createCalendar($components, $properties);
    }
}
