<?php

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\WeekStart;
use Eluceo\iCal\Domain\Enum\RecurrenceWeekDay;

class WeekStartTest extends TestCase
{
    public function testConstructorWithValidWeekStart(): void
    {
        $weekStart = new WeekStart(RecurrenceWeekDay::MONDAY());

        $this->assertInstanceOf(WeekStart::class, $weekStart);
        $this->assertSame('WKST=MO', $weekStart->__toString());
    }
}
