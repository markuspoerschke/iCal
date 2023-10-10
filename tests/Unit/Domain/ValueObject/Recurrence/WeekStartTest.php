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
