<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\Entity;

use DateTime as PhpDateTime;
use Eluceo\iCal\Domain\Enum\RecurrenceFrequency;
use Eluceo\iCal\Domain\Enum\RecurrenceWeekDay;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Day;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Until;
use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\Entity\RecurrenceRule;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Count;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Exclusion;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Frequency;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Interval;
use Eluceo\iCal\Domain\ValueObject\Recurrence\WeekStart;

class RecurrenceRuleTest extends TestCase
{
    public function testToStringWithAllPropertiesSet(): void
    {
        $recurrenceRule = (new RecurrenceRule())
            ->setUntil(new Until(new DateTime(new PhpDateTime('2023-12-31T12:00:00'), true)))
            ->setFrequency(new Frequency(RecurrenceFrequency::daily()))
            ->setCount(new Count(5))
            ->setInterval(new Interval(2))
            ->setWeekStart(new WeekStart(RecurrenceWeekDay::monday()))
            ->setBy(new By([new Day([RecurrenceWeekDay::thursday(-1)])]))
            ->setExclusions(new Exclusion([new DateTime(new PhpDateTime('2023-12-31T12:00:00'), true)]));

        $expected = 'UNTIL=20231231T120000;FREQ=DAILY;COUNT=5;INTERVAL=2;WKST=MO;BYDAY=-1TH';
        $this->assertSame($expected, $recurrenceRule->__toString());
    }

    public function testToStringWithNoPropertiesSet(): void
    {
        $recurrenceRule = new RecurrenceRule();
        $this->assertSame('', $recurrenceRule->__toString());
    }
}
