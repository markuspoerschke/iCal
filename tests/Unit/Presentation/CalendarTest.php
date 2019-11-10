<?php

namespace Eluceo\iCal\Test\Unit\Presentation;

use Eluceo\iCal\Presentation\Calendar;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function testEmptyCalendarToString()
    {
        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'END:VCALENDAR',
        ]);

        self::assertSame($expected, (string)Calendar::createCalendar());
    }

    public function testWithSingleComponentToString()
    {
        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'BEGIN:VEVENT',
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        $components = [
            Component::create('VEVENT'),
        ];

        $calendar = Calendar::createCalendar($components);

        self::assertSame($expected, (string)$calendar);
    }

    public function testWithMultipleComponentsToString()
    {
        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'BEGIN:VEVENT',
            'UID:event1',
            'END:VEVENT',
            'BEGIN:VEVENT',
            'UID:event2',
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        $components = [
            Component::create(
                'VEVENT',
                [
                    Property::create('UID', StringValue::fromString('event1')),
                ]
            ),
            Component::create(
                'VEVENT',
                [
                    Property::create('UID', StringValue::fromString('event2')),
                ]
            ),
        ];

        $calendar = Calendar::createCalendar($components);

        self::assertSame($expected, (string)$calendar);
    }

    public function testRenderOwnPropertiesBeforeComponents()
    {
        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'TEST:value',
            'TEST2:value2',
            'BEGIN:VEVENT',
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        $properties = [
            Property::create('TEST', StringValue::fromString('value')),
            Property::create('TEST2', StringValue::fromString('value2')),
        ];

        $components = [
            Component::create('VEVENT'),
        ];

        $calendar = Calendar::createCalendar($components, $properties);

        self::assertSame($expected, (string)$calendar);
    }
}
