<?php

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence\By;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Day;
use Eluceo\iCal\Domain\Enum\RecurrenceWeekDay;

class DayTest extends TestCase
{
    public function testConstructorWithSingleDay(): void
    {
        $day = new Day(RecurrenceWeekDay::monday());

        $this->assertInstanceOf(Day::class, $day);
        $this->assertSame('BYDAY=MO', $day->__toString());
    }

    public function testConstructorWithMultipleDays(): void
    {
        $days = new Day([RecurrenceWeekDay::monday(), RecurrenceWeekDay::sunday()]);

        $this->assertInstanceOf(Day::class, $days);
        $this->assertSame('BYDAY=MO,SU', $days->__toString());
    }

    public function testConstructorWithDayOffsets(): void
    {
        $days = new Day([
            RecurrenceWeekDay::monday(5),
            RecurrenceWeekDay::sunday(-3),
        ]);

        $this->assertInstanceOf(Day::class, $days);
        $this->assertSame('BYDAY=5MO,-3SU', $days->__toString());
    }

    public function testConstructorWithInvalidOffsetValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Day offsets must be between -53 and 53');

        new Day([RecurrenceWeekDay::monday(-54)]);
    }

    public function testConstructorWithInvalidDayType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Day must be an instance of RecurrenceWeekDay');

        new Day(['InvalidDay']);
    }
}
