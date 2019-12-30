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
        $components = array_map([$this->eventFactory, 'createComponent'], $calendar->getEvents());
        $properties = iterator_to_array($this->getProperties($calendar), false);

        return Calendar::createCalendar($components, $properties);
    }

    /**
     * @return Generator<Property>
     */
    private function getProperties(CalendarEntity $calendar): Generator
    {
        /* @see https://www.ietf.org/rfc/rfc5545.html#section-3.7.3 */
        yield Property::create('PRODID', TextValue::fromString($calendar->getProductIdentifier()));
        /* @see https://www.ietf.org/rfc/rfc5545.html#section-3.7.4 */
        yield Property::create('VERSION', TextValue::fromString('2.0'));
    }
}
