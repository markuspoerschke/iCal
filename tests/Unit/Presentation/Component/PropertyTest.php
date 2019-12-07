<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation\Component;

use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testPropertyToString(string $name, Value $value, array $parameters, string $expected)
    {
        self::assertSame($expected, (string) Property::create($name, $value, $parameters));
    }

    public function provideTestData()
    {
        yield 'property with simple value' => [
            'LOREM',
            TextValue::fromString('Ipsum'),
            [],
            'LOREM:Ipsum',
        ];

        yield 'property with parameters' => [
            'LOREM',
            TextValue::fromString('Ipsum'),
            [
                Parameter::create('TEST', TextValue::fromString('value')),
            ],
            'LOREM:TEST=value:Ipsum',
        ];

        yield 'property with multiple parameters' => [
            'LOREM',
            TextValue::fromString('Ipsum'),
            [
                Parameter::create('TEST', TextValue::fromString('value')),
                Parameter::create('TEST2', TextValue::fromString('value2')),
            ],
            'LOREM:TEST=value;TEST2=value2:Ipsum',
        ];
    }
}
