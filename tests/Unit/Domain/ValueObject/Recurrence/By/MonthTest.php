<?php

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence\By;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Month;
use InvalidArgumentException;

class MonthTest extends TestCase
{
    public function testConstructorWithSingleMonth(): void
    {
        $month = new Month(5);

        $this->assertInstanceOf(Month::class, $month);
        $this->assertSame('BYMONTH=5', $month->__toString());
    }

    public function testConstructorWithMultipleMonths(): void
    {
        $months = new Month([5, 8, 12]);

        $this->assertInstanceOf(Month::class, $months);
        $this->assertSame('BYMONTH=5,8,12', $months->__toString());
    }

    public function testConstructorWithInvalidMonthValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Month values must be between 1 and 12');

        new Month(0);
    }

    public function testConstructorWithInvalidMonthArrayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Month values must be between 1 and 12');

        new Month([5, 0, 12]);
    }
}
