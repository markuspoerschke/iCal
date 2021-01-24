<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
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
        self::assertSame($expected, (string) (new ListValue($values)));
    }

    public function provideTestData()
    {
        yield 'empty list value' => [
            [],
            '',
        ];
        yield 'single value' => [
            [new TextValue('Lorem')],
            'Lorem',
        ];
        yield 'multiple values without escaping' => [
            [
                new TextValue('Lorem'),
                new TextValue('Ipsum'),
                new TextValue('Dolor'),
            ],
            'Lorem,Ipsum,Dolor',
        ];
        yield 'multiple values with escaping' => [
            [
                new TextValue('Lorem'),
                new TextValue('Ips,um'),
                new TextValue('semi;colon:'),
            ],
            'Lorem,Ips\\,um,semi\\;colon:',
        ];
    }
}
