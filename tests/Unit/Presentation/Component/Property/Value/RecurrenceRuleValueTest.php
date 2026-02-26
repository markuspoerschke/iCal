<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Unit\Presentation\Component\Property\Value;

use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Enum\RecurrenceFrequency;
use Eluceo\iCal\Domain\Enum\RecurrenceWeekday;
use Eluceo\iCal\Domain\ValueObject\RecurrenceRule;
use Eluceo\iCal\Presentation\Component\Property\Value\RecurrenceRuleValue;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RecurrenceRuleValueTest extends TestCase
{
    public function testSimpleYearlyFrequency(): void
    {
        $rule = new RecurrenceRule(RecurrenceFrequency::YEARLY());
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=YEARLY', (string) $value);
    }

    public function testMonthlyWithInterval(): void
    {
        $rule = (new RecurrenceRule(RecurrenceFrequency::MONTHLY()))
            ->setInterval(2);
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=MONTHLY;INTERVAL=2', (string) $value);
    }

    public function testWeeklyWithCount(): void
    {
        $rule = (new RecurrenceRule(RecurrenceFrequency::WEEKLY()))
            ->setCount(10);
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=WEEKLY;COUNT=10', (string) $value);
    }

    public function testDailyWithUntil(): void
    {
        $until = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            '2030-12-31 23:59:59',
            new DateTimeZone('UTC')
        );

        $rule = (new RecurrenceRule(RecurrenceFrequency::DAILY()))
            ->setUntil($until);
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=DAILY;UNTIL=20301231T235959Z', (string) $value);
    }

    public function testWithWeekStartDay(): void
    {
        $rule = (new RecurrenceRule(RecurrenceFrequency::WEEKLY()))
            ->setWeekStartDay(RecurrenceWeekday::MONDAY());
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=WEEKLY;WKST=MO', (string) $value);
    }

    public function testWithByDay(): void
    {
        $rule = (new RecurrenceRule(RecurrenceFrequency::WEEKLY()))
            ->setByDay(['MO', 'WE', 'FR']);
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=WEEKLY;BYDAY=MO,WE,FR', (string) $value);
    }

    public function testWithByMonth(): void
    {
        $rule = (new RecurrenceRule(RecurrenceFrequency::YEARLY()))
            ->setByMonth([1, 6]);
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=YEARLY;BYMONTH=1,6', (string) $value);
    }

    public function testWithByMonthDay(): void
    {
        $rule = (new RecurrenceRule(RecurrenceFrequency::MONTHLY()))
            ->setByMonthDay([1, 15]);
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=MONTHLY;BYMONTHDAY=1,15', (string) $value);
    }

    public function testComplexRule(): void
    {
        $rule = (new RecurrenceRule(RecurrenceFrequency::MONTHLY()))
            ->setInterval(1)
            ->setCount(12)
            ->setByDay(['1MO'])
            ->setWeekStartDay(RecurrenceWeekday::SUNDAY());
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=MONTHLY;INTERVAL=1;COUNT=12;WKST=SU;BYDAY=1MO', (string) $value);
    }

    public function testUntilConvertsNonUtcToUtc(): void
    {
        $until = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            '2030-12-31 19:00:00',
            new DateTimeZone('America/New_York')
        );

        $rule = (new RecurrenceRule(RecurrenceFrequency::DAILY()))
            ->setUntil($until);
        $value = new RecurrenceRuleValue($rule);

        self::assertSame('FREQ=DAILY;UNTIL=20310101T000000Z', (string) $value);
    }

    public function testSetCountClearsUntil(): void
    {
        $until = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            '2030-12-31 23:59:59',
            new DateTimeZone('UTC')
        );

        $rule = (new RecurrenceRule(RecurrenceFrequency::DAILY()))
            ->setUntil($until)
            ->setCount(5);

        self::assertSame(5, $rule->getCount());
        self::assertNull($rule->getUntil());

        $value = new RecurrenceRuleValue($rule);
        self::assertSame('FREQ=DAILY;COUNT=5', (string) $value);
    }

    public function testSetUntilClearsCount(): void
    {
        $until = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            '2030-12-31 23:59:59',
            new DateTimeZone('UTC')
        );

        $rule = (new RecurrenceRule(RecurrenceFrequency::DAILY()))
            ->setCount(5)
            ->setUntil($until);

        self::assertNull($rule->getCount());
        self::assertNotNull($rule->getUntil());

        $value = new RecurrenceRuleValue($rule);
        self::assertSame('FREQ=DAILY;UNTIL=20301231T235959Z', (string) $value);
    }

    public function testSetIntervalThrowsForZero(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new RecurrenceRule(RecurrenceFrequency::DAILY()))->setInterval(0);
    }

    public function testSetIntervalThrowsForNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new RecurrenceRule(RecurrenceFrequency::DAILY()))->setInterval(-1);
    }

    public function testAllByParts(): void
    {
        $rule = (new RecurrenceRule(RecurrenceFrequency::YEARLY()))
            ->setBySecond([0])
            ->setByMinute([30])
            ->setByHour([9])
            ->setByDay(['MO'])
            ->setByMonthDay([1])
            ->setByYearDay([1])
            ->setByWeekNo([1])
            ->setByMonth([1])
            ->setBySetPos([1]);
        $value = new RecurrenceRuleValue($rule);

        self::assertSame(
            'FREQ=YEARLY;BYDAY=MO;BYMONTHDAY=1;BYYEARDAY=1;BYWEEKNO=1;BYMONTH=1;BYSETPOS=1;BYHOUR=9;BYMINUTE=30;BYSECOND=0',
            (string) $value
        );
    }
}
