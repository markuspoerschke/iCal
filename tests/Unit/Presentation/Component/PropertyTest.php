<?php

namespace Eluceo\iCal\Test\Unit\Presentation\Component;

use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value;
use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testPropertyToString(string $name, Value $value, array $parameters, string $expected)
    {
        self::assertSame($expected, (string)Property::create($name, $value, $parameters));
    }

    public function provideTestData()
    {
        yield 'property with simple value' => [
            'LOREM',
            StringValue::fromString('Ipsum'),
            [],
            'LOREM:Ipsum',
        ];

        yield 'property with parameters' => [
            'LOREM',
            StringValue::fromString('Ipsum'),
            [
                Parameter::create('TEST', StringValue::fromString('value')),
            ],
            'LOREM:TEST=value:Ipsum',
        ];

        yield 'property with multiple parameters' => [
            'LOREM',
            StringValue::fromString('Ipsum'),
            [
                Parameter::create('TEST', StringValue::fromString('value')),
                Parameter::create('TEST2', StringValue::fromString('value2')),
            ],
            'LOREM:TEST=value;TEST2=value2:Ipsum',
        ];
    }
}
