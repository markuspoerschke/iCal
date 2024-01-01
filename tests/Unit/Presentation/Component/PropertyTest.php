<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
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
        self::assertSame($expected, (string) new Property($name, $value, $parameters));
    }

    public function provideTestData()
    {
        yield 'property with simple value' => [
            'LOREM',
            new TextValue('Ipsum'),
            [],
            'LOREM:Ipsum',
        ];

        yield 'property with parameters' => [
            'LOREM',
            new TextValue('Ipsum'),
            [
                new Parameter('TEST', new TextValue('value')),
            ],
            'LOREM;TEST=value:Ipsum',
        ];

        yield 'property with multiple parameters' => [
            'LOREM',
            new TextValue('Ipsum'),
            [
                new Parameter('TEST', new TextValue('value')),
                new Parameter('TEST2', new TextValue('value2')),
            ],
            'LOREM;TEST=value;TEST2=value2:Ipsum',
        ];
    }
}
