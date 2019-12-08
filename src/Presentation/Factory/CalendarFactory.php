<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\Entity\Calendar as CalendarEntity;
use Eluceo\iCal\Presentation\Calendar;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Generator;

class CalendarFactory
{
    private EventFactory $eventFactory;

    public function __construct(?EventFactory $eventFactory = null)
    {
        $this->eventFactory = $eventFactory ?? new EventFactory();
    }

    public function createCalendar(CalendarEntity $calendar): Calendar
    {
        /** @var Component[] $components */
        $components = [];
        foreach ($calendar->getEvents() as $event) {
            $components[] = $this->eventFactory->createComponent($event);
        }

        /** @var Property[] $properties */
        $properties = iterator_to_array($this->getProperties($calendar));

        return Calendar::createCalendar($components, $properties);
    }

    private function getProperties(CalendarEntity $calendar): Generator
    {
        yield Property::create('PRODID', TextValue::fromString($calendar->getProductIdentifier()));
        yield Property::create('VERSION', TextValue::fromString('2.0'));
    }
}
