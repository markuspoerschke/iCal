<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Generator;

class CalendarFactory
{
    private EventFactory $eventFactory;
    private TimeZoneFactory $timeZoneFactory;

    public function __construct(?EventFactory $eventFactory = null, ?TimeZoneFactory $timeZoneFactory = null)
    {
        $this->eventFactory = $eventFactory ?? new EventFactory();
        $this->timeZoneFactory = $timeZoneFactory ?? new TimeZoneFactory();
    }

    public function createCalendar(Calendar $calendar): Component
    {
        $components = $this->createCalendarComponents($calendar);
        $properties = iterator_to_array($this->getProperties($calendar), false);

        return new Component('VCALENDAR', $properties, $components);
    }

    /**
     * @return iterable<Component>
     */
    protected function createCalendarComponents(Calendar $calendar): iterable
    {
        yield from $this->eventFactory->createComponents($calendar->getEvents());
        yield from $this->timeZoneFactory->createComponents($calendar->getTimeZones());
    }

    /**
     * @return Generator<Property>
     */
    private function getProperties(Calendar $calendar): Generator
    {
        /* @see https://www.ietf.org/rfc/rfc5545.html#section-3.7.3 */
        yield new Property('PRODID', new TextValue($calendar->getProductIdentifier()));
        /* @see https://www.ietf.org/rfc/rfc5545.html#section-3.7.4 */
        yield new Property('VERSION', new TextValue('2.0'));
        /* @see https://www.ietf.org/rfc/rfc5545.html#section-3.7.1 */
        yield new Property('CALSCALE', new TextValue('GREGORIAN'));
    }
}
