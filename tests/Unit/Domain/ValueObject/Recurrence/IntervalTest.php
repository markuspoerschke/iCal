<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Interval;
use InvalidArgumentException;

class IntervalTest extends TestCase
{
    public function testConstructorWithValidInterval(): void
    {
        $interval = new Interval(2);

        $this->assertInstanceOf(Interval::class, $interval);
        $this->assertSame('INTERVAL=2', $interval->__toString());
    }

    public function testConstructorWithInvalidIntervalValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Interval must be greater than 0');

        new Interval(0);
    }

    public function testConstructorWithNegativeIntervalValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Interval must be greater than 0');

        new Interval(-2);
    }
}
