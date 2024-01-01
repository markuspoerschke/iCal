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

use DateInterval;
use Eluceo\iCal\Presentation\Component\Property\Value\DurationValue;
use PHPUnit\Framework\TestCase;

class DurationValueTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testDurationToString(DateInterval $duration, string $expected)
    {
        $actual = (new DurationValue($duration))->__toString();
        self::assertSame($expected, $actual);
    }

    public function provideTestData()
    {
        yield '30 days' => [
            new DateInterval('P30D'),
            'P30D',
        ];

        yield '-30 days' => [
            DateInterval::createFromDateString('-30 days'),
            '-P30D',
        ];

        yield 'time based' => [
            new DateInterval('PT10H20M30S'),
            'PT10H20M30S',
        ];

        yield '-15 minutes' => [
            DateInterval::createFromDateString('-15 minutes'),
            '-PT15M',
        ];

        yield 'days and time' => [
            new DateInterval('P1MT10H'),
            'P31DT10H',
        ];
    }
}
