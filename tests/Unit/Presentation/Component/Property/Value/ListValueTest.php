<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value\ListValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use PHPUnit\Framework\TestCase;

class ListValueTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testStringValueEscaping(array $values, string $expected)
    {
        self::assertSame($expected, (string) ListValue::fromStringValues($values));
    }

    public function provideTestData()
    {
        yield 'empty list value' => [
            [],
            '',
        ];
        yield 'single value' => [
            [TextValue::fromString('Lorem')],
            'Lorem',
        ];
        yield 'multiple values without escaping' => [
            [
                TextValue::fromString('Lorem'),
                TextValue::fromString('Ipsum'),
                TextValue::fromString('Dolor'),
            ],
            'Lorem,Ipsum,Dolor',
        ];
        yield 'multiple values with escaping' => [
            [
                TextValue::fromString('Lorem'),
                TextValue::fromString('Ips,um'),
                TextValue::fromString('semi;colon:'),
            ],
            'Lorem,Ips\\,um,semi\\;colon:',
        ];
    }
}
