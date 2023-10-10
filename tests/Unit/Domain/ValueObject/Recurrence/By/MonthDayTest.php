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
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\MonthDay;
use InvalidArgumentException;

class MonthDayTest extends TestCase
{
    public function testConstructorWithSingleMonthDay(): void
    {
        $monthDay = new MonthDay(15);

        $this->assertInstanceOf(MonthDay::class, $monthDay);
        $this->assertSame('BYMONTHDAY=15', $monthDay->__toString());
    }

    public function testConstructorWithMultipleMonthDays(): void
    {
        $monthDays = new MonthDay([15, -1, -31]);

        $this->assertInstanceOf(MonthDay::class, $monthDays);
        $this->assertSame('BYMONTHDAY=15,-1,-31', $monthDays->__toString());
    }

    public function testConstructorWithInvalidMonthDayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Month day values must be between 1 and 31, or -1 and -31');

        new MonthDay(0);
    }

    public function testConstructorWithInvalidMonthDayArrayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Month day values must be between 1 and 31, or -1 and -31');

        new MonthDay([15, 32, -33]);
    }
}
