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
use Eluceo\iCal\Presentation\ContentLine;
use Eluceo\iCal\Presentation\Factory\EventFactory;
use PHPUnit\Framework\TestCase;

class CalendarFactoryTest extends TestCase
{
    public function testMinimalEvent()
    {
        $currentTime = new Timestamp(
            DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                '2019-11-10 11:22:33',
                new DateTimeZone('UTC')
            )
        );

        $event = (new Event(new UniqueIdentifier('event1')))->touch($currentTime);

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'UID:event1',
            'DTSTAMP:20191110T112233Z',
            'END:VEVENT',
            '',
        ]);

        self::assertSame($expected, (string) (new EventFactory())->createComponent($event));
    }

    public function testEventWithSummaryAndDescription()
    {
        $event = (new Event())
            ->setSummary('Lorem Summary')
            ->setDescription('Lorem Description');

        self::assertEventRendersCorrect($event, [
            'SUMMARY:Lorem Summary',
            'DESCRIPTION:Lorem Description',
        ]);
    }

    public function testEventWithLocation()
    {
        $geographicalPosition = new GeographicPosition(51.333333333333, 7.05);
        $location = (new Location('Location Name'))->withGeographicPosition($geographicalPosition);
        $event = (new Event())->setLocation($location);

        self::assertEventRendersCorrect(
            $event,
            [
                'LOCATION:Location Name',
                'GEO:51.333333;7.050000',
            ]
        );
    }

    public function testSingleDayEvent()
    {
        $event = (new Event())->setOccurrence(new SingleDay(new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24'))));

        self::assertEventRendersCorrect($event, [
            'DTSTART:20301224',
        ]);
    }

    public function testMultiDayEvent()
    {
        $firstDay = new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24'));
        $lastDay = new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-26'));
        $occurrence = new MultiDay($firstDay, $lastDay);
        $event = (new Event())->setOccurrence($occurrence);

        self::assertEventRendersCorrect($event, [
            'DTSTART:20301224',
            'DTEND:20301227',
        ]);
    }

    public function testTimespanEvent()
    {
        $begin = new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i', '2030-12-24 12:15'));
        $end = new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i', '2030-12-24 13:45'));
        $occurrence = new TimeSpan($begin, $end);
        $event = (new Event())->setOccurrence($occurrence);

        self::assertEventRendersCorrect($event, [
            'DTSTART:20301224T121500',
            'DTEND:20301224T134500',
        ]);
    }

    private static function assertEventRendersCorrect(Event $event, array $expected)
    {
        $resultAsString = (string) (new EventFactory())->createComponent($event);

        $resultAsArray = explode(ContentLine::LINE_SEPARATOR, $resultAsString);

        self::assertGreaterThan(5, count($resultAsArray), 'No additional content lines were produced.');

        $resultAsArray = array_slice($resultAsArray, 3, -2);
        self::assertSame($expected, $resultAsArray);
    }
}
