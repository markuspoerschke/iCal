<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation;

use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\ContentLine;
use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase
{
    public function testEmptyComponentToString()
    {
        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'END:VEVENT',
            '',
        ]);

        self::assertSame(
            $expected,
            (string) (new Component('VEVENT'))
        );
    }

    public function testComponentWithPropertiesToString()
    {
        $properties = [
            new Property('TEST', new TextValue('value')),
            new Property('TEST2', new TextValue('value2')),
        ];

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'TEST:value',
            'TEST2:value2',
            'END:VEVENT',
            '',
        ]);

        self::assertSame(
            $expected,
            (string) (new Component('VEVENT', $properties))
        );
    }

    public function testWithProperties()
    {
        $component = new Component('VEVENT', [new Property('TEST', new TextValue('value'))]);
        $newComponent = $component->withProperty(new Property('TEST2', new TextValue('value2')));

        self::assertNotSame($component, $newComponent);

        $expectedOutputFromComponent = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'TEST:value',
            'END:VEVENT',
            '',
        ]);

        $expectedOutputFromNewComponent = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'TEST:value',
            'TEST2:value2',
            'END:VEVENT',
            '',
        ]);

        self::assertSame($expectedOutputFromComponent, (string) $component);
        self::assertSame($expectedOutputFromNewComponent, (string) $newComponent);
    }
}
