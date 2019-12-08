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

use DateInterval;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Domain\ValueObject\Occurrence;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\DateTimeValue;
use Eluceo\iCal\Presentation\Component\Property\Value\DateValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Generator;

class EventFactory
{
    public function createComponent(Event $event): Component
    {
        return Component::create('VEVENT', iterator_to_array($this->getProperties($event)));
    }

    private function getProperties(Event $event): Generator
    {
        yield Property::create('UID', TextValue::fromString((string) $event->getUniqueIdentifier()));
        yield Property::create('DTSTAMP', DateTimeValue::fromTimestamp($event->getTouchedAt()));

        if ($event->hasSummary()) {
            yield Property::create('SUMMARY', TextValue::fromString($event->getSummary()));
        }

        if ($event->hasDescription()) {
            yield Property::create('DESCRIPTION', TextValue::fromString($event->getDescription()));
        }

        if ($event->hasOccurrence()) {
            yield from $this->getOccurrenceProperties($event->getOccurrence());
        }
    }

    private function getOccurrenceProperties(Occurrence $occurrence): Generator
    {
        if ($occurrence instanceof SingleDay) {
            yield Property::create('DTSTART', DateValue::fromDate($occurrence->getDate()));
        } elseif ($occurrence instanceof MultiDay) {
            yield Property::create('DTSTART', DateValue::fromDate($occurrence->getFirstDay()));
            yield Property::create('DTEND', DateValue::fromDate($occurrence->getLastDay()->add(new DateInterval('P1D'))));
        } elseif ($occurrence instanceof TimeSpan) {
            yield Property::create('DTSTART', DateTimeValue::fromDateTime($occurrence->getBegin()));
            yield Property::create('DTEND', DateTimeValue::fromDateTime($occurrence->getEnd()));
        }
    }
}
