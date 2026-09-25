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

use Eluceo\iCal\Domain\Enum\RecurrenceFrequency;
use PHPUnit\Framework\TestCase;

class RecurrenceFrequencyTest extends TestCase
{
    /**
     * @dataProvider provideFrequencies
     */
    public function testSameInstanceIsReturnedOnEveryCall(string $method): void
    {
        self::assertSame(RecurrenceFrequency::{$method}(), RecurrenceFrequency::{$method}());
    }

    /**
     * @dataProvider provideFrequencies
     */
    public function testStringRepresentation(string $method): void
    {
        self::assertSame($method, (string) RecurrenceFrequency::{$method}());
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideFrequencies(): iterable
    {
        yield 'SECONDLY' => ['SECONDLY'];
        yield 'MINUTELY' => ['MINUTELY'];
        yield 'HOURLY' => ['HOURLY'];
        yield 'DAILY' => ['DAILY'];
        yield 'WEEKLY' => ['WEEKLY'];
        yield 'MONTHLY' => ['MONTHLY'];
        yield 'YEARLY' => ['YEARLY'];
    }
}
