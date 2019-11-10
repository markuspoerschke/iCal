<?php

namespace Eluceo\iCal\Test\Unit\Presentation;

use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;
use Eluceo\iCal\Presentation\Component\Property;
use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase
{
    public function testEmptyComponentToString()
    {
        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'END:VEVENT',
        ]);

        self::assertSame(
            $expected,
            (string)Component::create('VEVENT')
        );
    }

    public function testComponentWithPropertiesToString()
    {
        $properties = [
            Property::create('TEST', StringValue::fromString('value')),
            Property::create('TEST2', StringValue::fromString('value2')),
        ];

        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'TEST:value',
            'TEST2:value2',
            'END:VEVENT',
        ]);

        self::assertSame(
            $expected,
            (string)Component::create('VEVENT', $properties)
        );
    }
}
