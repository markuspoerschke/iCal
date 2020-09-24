<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation;

use Eluceo\iCal\Presentation\Calendar;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\ContentLine;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function testEmptyCalendarToString()
    {
        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'END:VCALENDAR',
            '',
        ]);

        self::assertSame($expected, (string) Calendar::createCalendar());
    }

    public function testWithSingleComponentToString()
    {
        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'BEGIN:VEVENT',
            'END:VEVENT',
            'END:VCALENDAR',
            '',
        ]);

        $components = [
            new Component('VEVENT'),
        ];

        $calendar = Calendar::createCalendar($components);

        self::assertSame($expected, (string) $calendar);
    }

    public function testWithMultipleComponentsToString()
    {
        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'BEGIN:VEVENT',
            'UID:event1',
            'END:VEVENT',
            'BEGIN:VEVENT',
            'UID:event2',
            'END:VEVENT',
            'END:VCALENDAR',
            '',
        ]);

        $components = [
            new Component(
                'VEVENT',
                [
                    new Property('UID', new TextValue('event1')),
                ]
            ),
            new Component(
                'VEVENT',
                [
                    new Property('UID', new TextValue('event2')),
                ]
            ),
        ];

        $calendar = Calendar::createCalendar($components);

        self::assertSame($expected, (string) $calendar);
    }

    public function testRenderOwnPropertiesBeforeComponents()
    {
        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VCALENDAR',
            'TEST:value',
            'TEST2:value2',
            'BEGIN:VEVENT',
            'END:VEVENT',
            'END:VCALENDAR',
            '',
        ]);

        $properties = [
            new Property('TEST', new TextValue('value')),
            new Property('TEST2', new TextValue('value2')),
        ];

        $components = [
            new Component('VEVENT'),
        ];

        $calendar = Calendar::createCalendar($components, $properties);

        self::assertSame($expected, (string) $calendar);
    }
}
