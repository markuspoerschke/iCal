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
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\WeekNumber;
use InvalidArgumentException;

class WeekNumberTest extends TestCase
{
    public function testConstructorWithSingleWeekNumber(): void
    {
        $weekNumber = new WeekNumber(15);

        $this->assertInstanceOf(WeekNumber::class, $weekNumber);
        $this->assertSame('BYWEEKNO=15', $weekNumber->__toString());
    }

    public function testConstructorWithMultipleWeekNumbers(): void
    {
        $weekNumbers = new WeekNumber([15, -1, -53]);

        $this->assertInstanceOf(WeekNumber::class, $weekNumbers);
        $this->assertSame('BYWEEKNO=15,-1,-53', $weekNumbers->__toString());
    }

    public function testConstructorWithInvalidWeekNumberValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Week number values must be between 1 and 53, or -1 and -53');

        new WeekNumber(0);
    }

    public function testConstructorWithInvalidWeekNumberArrayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Week number values must be between 1 and 53, or -1 and -53');

        new WeekNumber([15, 54, -54]);
    }
}
