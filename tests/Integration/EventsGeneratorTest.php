<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Integration;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Generator;
use PHPUnit\Framework\TestCase;

class EventsGeneratorTest extends TestCase
{
    public function testEventsGeneratorCreatesIcsContent(): void
    {
        $generator = function (): Generator {
            $day = new DateTimeImmutable('2020-01-01 15:00:00', new DateTimeZone('UTC'));
            $timestamp = new Timestamp($day);
            $dayInterval = new DateInterval('P1D');
            for ($i = 0; $i < 3; ++$i) {
                yield (new Event(new UniqueIdentifier('event-' . $i)))
                    ->touch($timestamp)
                    ->setSummary('Event ' . $i)
                    ->setOccurrence(new SingleDay(new Date($day)));
                $day = $day->add($dayInterval);
            }
        };

        $calendar = new Calendar($generator());
        $componentFactory = new CalendarFactory();
        $calendarComponent = $componentFactory->createCalendar($calendar);

        $expected = [
            'BEGIN:VCALENDAR',
            'PRODID:-//eluceo/ical//2.0/EN',
            'VERSION:2.0',
            'CALSCALE:GREGORIAN',
            'BEGIN:VEVENT',
            'UID:event-0',
            'DTSTAMP:20200101T150000Z',
            'SUMMARY:Event 0',
            'DTSTART;VALUE=DATE:20200101',
            'END:VEVENT',
            'BEGIN:VEVENT',
            'UID:event-1',
            'DTSTAMP:20200101T150000Z',
            'SUMMARY:Event 1',
            'DTSTART;VALUE=DATE:20200102',
            'END:VEVENT',
            'BEGIN:VEVENT',
            'UID:event-2',
            'DTSTAMP:20200101T150000Z',
            'SUMMARY:Event 2',
            'DTSTART;VALUE=DATE:20200103',
            'END:VEVENT',
            'END:VCALENDAR',
        ];
        $contentLines = array_map('trim', iterator_to_array($calendarComponent, false));

        self::assertSame($expected, $contentLines);
    }
}
