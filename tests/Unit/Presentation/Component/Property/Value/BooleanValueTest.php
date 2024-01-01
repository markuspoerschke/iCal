<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value\BooleanValue;
use PHPUnit\Framework\TestCase;

class BooleanValueTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testStringValueEscaping(bool $inputValue, string $expected)
    {
        self::assertSame($expected, (string) (new BooleanValue($inputValue)));
    }

    public function provideTestData()
    {
        yield 'Test bool true is same' => [
            true,
            'TRUE',
        ];

        yield 'Test bool false is same' => [
            false,
            'FALSE',
        ];
    }
}
