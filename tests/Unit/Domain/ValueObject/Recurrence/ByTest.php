<?php

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence;

use Eluceo\iCal\Domain\Enum\RecurrenceWeekDay;
use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Second;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Minute;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Hour;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Day;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\MonthDay;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Month;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\YearDay;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\SetPosition;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\WeekNumber;
use InvalidArgumentException;

class ByTest extends TestCase
{
    public function testConstructorWithValidByValues(): void
    {
        $byArray = [
            new Second(15),
            new Minute(30),
            new Hour(4),
            new Day(RecurrenceWeekDay::monday()),
            new MonthDay(15),
            new Month(6),
            new YearDay(200),
            new SetPosition(3),
            new WeekNumber(10),
        ];

        $by = new By($byArray);

        $this->assertInstanceOf(By::class, $by);
        $expectedString = implode(';', array_map(static function ($byValue) {
            return (string)$byValue;
        }, $byArray));
        $this->assertSame($expectedString, $by->__toString());
    }

    public function testConstructorWithInvalidByValues(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Values must be one of: Day, Hour, Minute, Month, MonthDay, Second, SetPosition, WeekNumber, YearDay');

        $byArray = [
            new Second(15),
            'InvalidValue',
        ];

        new By($byArray);
    }
}
