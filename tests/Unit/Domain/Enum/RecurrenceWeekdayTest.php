<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\Enum;

use Eluceo\iCal\Domain\Enum\RecurrenceWeekday;
use PHPUnit\Framework\TestCase;

class RecurrenceWeekdayTest extends TestCase
{
    /**
     * @dataProvider provideWeekdays
     */
    public function testSameInstanceIsReturnedOnEveryCall(string $method): void
    {
        self::assertSame(RecurrenceWeekday::{$method}(), RecurrenceWeekday::{$method}());
    }

    /**
     * @dataProvider provideWeekdays
     */
    public function testStringRepresentation(string $method, string $expected): void
    {
        self::assertSame($expected, (string) RecurrenceWeekday::{$method}());
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function provideWeekdays(): iterable
    {
        yield 'SUNDAY' => ['SUNDAY', 'SU'];
        yield 'MONDAY' => ['MONDAY', 'MO'];
        yield 'TUESDAY' => ['TUESDAY', 'TU'];
        yield 'WEDNESDAY' => ['WEDNESDAY', 'WE'];
        yield 'THURSDAY' => ['THURSDAY', 'TH'];
        yield 'FRIDAY' => ['FRIDAY', 'FR'];
        yield 'SATURDAY' => ['SATURDAY', 'SA'];
    }
}
