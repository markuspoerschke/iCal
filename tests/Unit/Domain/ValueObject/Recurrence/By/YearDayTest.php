<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence\By;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\YearDay;
use InvalidArgumentException;

class YearDayTest extends TestCase
{
    public function testConstructorWithSingleYearDay(): void
    {
        $yearDay = new YearDay([100]);

        $this->assertInstanceOf(YearDay::class, $yearDay);
        $this->assertSame('BYYEARDAY=100', $yearDay->__toString());
    }

    public function testConstructorWithMultipleYearDays(): void
    {
        $yearDays = new YearDay([100, -1, -366]);

        $this->assertInstanceOf(YearDay::class, $yearDays);
        $this->assertSame('BYYEARDAY=100,-1,-366', $yearDays->__toString());
    }

    public function testConstructorWithInvalidYearDayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Year day values must be between 1 and 366, or -1 and -366');

        new YearDay([0]);
    }

    public function testConstructorWithInvalidYearDayArrayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Year day values must be between 1 and 366, or -1 and -366');

        new YearDay([100, 367, -367]);
    }
}
