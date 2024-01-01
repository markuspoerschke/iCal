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

use Eluceo\iCal\Presentation\Component\Property\Value\UtcOffsetValue;
use PHPUnit\Framework\TestCase;

class UtcOffsetValueTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testFromSeconds(int $seconds, string $expected): void
    {
        $actual = UtcOffsetValue::fromSeconds($seconds)->__toString();

        self::assertSame($expected, $actual);
    }

    public function provideTestData(): array
    {
        return [
            [0, '+0000'],
            [3600, '+0100'],
            [4800, '+0120'],
            [43200, '+1200'],
            [-3600, '-0100'],
            [-4800, '-0120'],
            [-43200, '-1200'],
        ];
    }
}
