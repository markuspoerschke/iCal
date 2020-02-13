<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Unit\Presentation\Factory;

use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\GeographicPosition;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Factory\EventFactory;
use PHPUnit\Framework\TestCase;

class CalendarFactoryTest extends TestCase
{
    public function testMinimalEvent()
    {
        $currentTime = Timestamp::fromDateTimeInterface(
            DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                '2019-11-10 11:22:33',
                new DateTimeZone('UTC')
            )
        );

        $event = Event::create(UniqueIdentifier::fromString('event1'))->touch($currentTime);

        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'UID:event1',
            'DTSTAMP:20191110T112233Z',
            'END:VEVENT',
        ]);

        self::assertSame($expected, (string) (new EventFactory())->createComponent($event));
    }

    public function testEventWithSummaryAndDescription()
    {
        $event = Event::create()
            ->setSummary('Lorem Summary')
            ->setDescription('Lorem Description');

        $this->assertEventRendersCorrect($event, [
            'SUMMARY:Lorem Summary',
            'DESCRIPTION:Lorem Description',
        ]);
    }

    public function testEventWithLocation()
    {
        $geographicalPosition = GeographicPosition::fromLatitudeAndLongitude(51.333333333333, 7.05);
        $location = Location::fromString('Location Name')->withGeographicPosition($geographicalPosition);
        $event = Event::create()->setLocation($location);

        $this->assertEventRendersCorrect(
            $event,
            [
                'LOCATION:Location Name',
                'GEO:51.333333;7.050000',
            ]
        );
    }

    public function testSingleDayEvent()
    {
        $event = Event::create()->setOccurrence(SingleDay::fromDate(Date::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24'))));

        $this->assertEventRendersCorrect($event, [
            'DTSTART:20301224',
        ]);
    }

    public function testMultiDayEvent()
    {
        $firstDay = Date::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24'));
        $lastDay = Date::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-26'));
        $occurrence = MultiDay::fromDates($firstDay, $lastDay);
        $event = Event::create()->setOccurrence($occurrence);

        $this->assertEventRendersCorrect($event, [
            'DTSTART:20301224',
            'DTEND:20301227',
        ]);
    }

    public function testTimespanEvent()
    {
        $begin = DateTime::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d H:i', '2030-12-24 12:15'));
        $end = DateTime::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d H:i', '2030-12-24 13:45'));
        $occurrence = TimeSpan::create($begin, $end);
        $event = Event::create()->setOccurrence($occurrence);

        $this->assertEventRendersCorrect($event, [
            'DTSTART:20301224T121500',
            'DTEND:20301224T134500',
        ]);
    }

    private function assertEventRendersCorrect(Event $event, array $expected)
    {
        $resultAsString = (string) (new EventFactory())->createComponent($event);

        $resultAsArray = explode(Component::LINE_SEPARATOR, $resultAsString);

        self::assertGreaterThan(4, count($resultAsArray), 'No additional content lines were produced.');

        $resultAsArray = array_slice($resultAsArray, 3, -1);
        self::assertSame($expected, $resultAsArray);
    }
}
