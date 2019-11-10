<?php


namespace Eluceo\iCal\Test\Unit\Presentation\Factory;

use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use PHPUnit\Framework\TestCase;

class CalendarFactoryTest extends TestCase
{
    public function testRenderEmptyCalendar()
    {
        $calendar = Calendar::create(UniqueIdentifier::fromString('1234'));
        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'PRODID:1234',
            'VERSION:2.0',
            'END:VCALENDAR'
        ]);

        self::assertSame($expected, (string)(new CalendarFactory())->createCalendar($calendar));
    }

    public function testRenderWithEvents()
    {
        $currentTime = Timestamp::fromDateTimeInterface(
            DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                '2019-11-10 11:22:33',
                new DateTimeZone('UTC')
            )
        );
        $calendar = Calendar::create(
            UniqueIdentifier::fromString('1234'),
            [
                Event::create(UniqueIdentifier::fromString('event1'))->touch($currentTime),
                Event::create(UniqueIdentifier::fromString('event2'))->touch($currentTime),
            ],
        );

        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'PRODID:1234',
            'VERSION:2.0',
            'BEGIN:VEVENT',
            'UID:event1',
            'DTSTAMP:20191110T112233Z',
            'END:VEVENT',
            'BEGIN:VEVENT',
            'UID:event2',
            'DTSTAMP:20191110T112233Z',
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        self::assertSame($expected, (string)(new CalendarFactory())->createCalendar($calendar));
    }
}
