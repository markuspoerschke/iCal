<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject;

use DateTimeImmutable;
use Eluceo\iCal\Domain\Enum\RecurrenceFrequency;
use Eluceo\iCal\Domain\ValueObject\RecurrenceRule;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RecurrenceRuleTest extends TestCase
{
    public function testSetCountClearsUntil(): void
    {
        $rule = self::createRule()
            ->setUntil(new DateTimeImmutable('2030-12-31 23:59:59'))
            ->setCount(5);

        self::assertSame(5, $rule->getCount());
        self::assertNull($rule->getUntil());
    }

    public function testSetUntilClearsCount(): void
    {
        $rule = self::createRule()
            ->setCount(5)
            ->setUntil(new DateTimeImmutable('2030-12-31 23:59:59'));

        self::assertNull($rule->getCount());
        self::assertNotNull($rule->getUntil());
    }

    /**
     * @dataProvider provideInvalidIntervals
     */
    public function testSetIntervalThrowsForInvalidValue(int $interval): void
    {
        $this->expectException(InvalidArgumentException::class);

        self::createRule()->setInterval($interval);
    }

    /**
     * @return iterable<string, array{int}>
     */
    public static function provideInvalidIntervals(): iterable
    {
        yield 'zero' => [0];
        yield 'negative' => [-1];
    }

    /**
     * @dataProvider provideInvalidCounts
     */
    public function testSetCountThrowsForInvalidValue(int $count): void
    {
        $this->expectException(InvalidArgumentException::class);

        self::createRule()->setCount($count);
    }

    /**
     * @return iterable<string, array{int}>
     */
    public static function provideInvalidCounts(): iterable
    {
        yield 'zero' => [0];
        yield 'negative' => [-3];
    }

    /**
     * @dataProvider provideEmptyRuleParts
     */
    public function testRulePartThrowsForEmptyArray(string $setter): void
    {
        $this->expectException(InvalidArgumentException::class);

        self::createRule()->{$setter}([]);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideEmptyRuleParts(): iterable
    {
        foreach (self::rulePartSetters() as $setter) {
            yield $setter => [$setter];
        }
    }

    /**
     * @dataProvider provideOutOfRangeRuleParts
     *
     * @param int[] $values
     */
    public function testRulePartThrowsForOutOfRangeValue(string $setter, array $values): void
    {
        $this->expectException(InvalidArgumentException::class);

        self::createRule()->{$setter}($values);
    }

    /**
     * @return iterable<string, array{string, int[]}>
     */
    public static function provideOutOfRangeRuleParts(): iterable
    {
        yield 'BYMONTHDAY zero' => ['setByMonthDay', [0]];
        yield 'BYMONTHDAY above range' => ['setByMonthDay', [32]];
        yield 'BYMONTHDAY below range' => ['setByMonthDay', [-32]];
        yield 'BYYEARDAY zero' => ['setByYearDay', [0]];
        yield 'BYYEARDAY above range' => ['setByYearDay', [367]];
        yield 'BYWEEKNO above range' => ['setByWeekNo', [54]];
        yield 'BYMONTH zero' => ['setByMonth', [0]];
        yield 'BYMONTH above range' => ['setByMonth', [99]];
        yield 'BYMONTH negative' => ['setByMonth', [-1]];
        yield 'BYSETPOS zero' => ['setBySetPos', [0]];
        yield 'BYHOUR above range' => ['setByHour', [25]];
        yield 'BYHOUR negative' => ['setByHour', [-1]];
        yield 'BYMINUTE above range' => ['setByMinute', [60]];
        yield 'BYSECOND above range' => ['setBySecond', [61]];
    }

    /**
     * @dataProvider provideValidRuleParts
     *
     * @param int[] $values
     */
    public function testRulePartAcceptsBoundaryValues(string $setter, array $values): void
    {
        $rule = self::createRule()->{$setter}($values);

        self::assertSame($values, $rule->{'get' . substr($setter, 3)}());
    }

    /**
     * @return iterable<string, array{string, int[]}>
     */
    public static function provideValidRuleParts(): iterable
    {
        yield 'BYMONTHDAY' => ['setByMonthDay', [1, 31, -1, -31]];
        yield 'BYYEARDAY' => ['setByYearDay', [1, 366, -1, -366]];
        yield 'BYWEEKNO' => ['setByWeekNo', [1, 53, -1, -53]];
        yield 'BYMONTH' => ['setByMonth', [1, 12]];
        yield 'BYSETPOS' => ['setBySetPos', [1, 366, -1, -366]];
        yield 'BYHOUR' => ['setByHour', [0, 23]];
        yield 'BYMINUTE' => ['setByMinute', [0, 59]];
        yield 'BYSECOND' => ['setBySecond', [0, 60]];
    }

    /**
     * @dataProvider provideInvalidByDayValues
     */
    public function testSetByDayThrowsForInvalidValue(string $day): void
    {
        $this->expectException(InvalidArgumentException::class);

        self::createRule()->setByDay([$day]);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideInvalidByDayValues(): iterable
    {
        yield 'unknown weekday' => ['MOO'];
        yield 'lowercase weekday' => ['monday'];
        yield 'ordinal out of range' => ['54MO'];
        yield 'zero ordinal' => ['0MO'];
        yield 'content line injection' => ["MO\r\nX-EVIL:1"];
        yield 'rule part separator' => ['MO;FREQ=DAILY'];
    }

    /**
     * @dataProvider provideValidByDayValues
     */
    public function testSetByDayAcceptsValidValue(string $day): void
    {
        $rule = self::createRule()->setByDay([$day]);

        self::assertSame([$day], $rule->getByDay());
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideValidByDayValues(): iterable
    {
        yield 'weekday' => ['SU'];
        yield 'positive ordinal' => ['1MO'];
        yield 'signed positive ordinal' => ['+2TU'];
        yield 'negative ordinal' => ['-1FR'];
        yield 'highest ordinal' => ['53SA'];
        yield 'lowest ordinal' => ['-53WE'];
    }

    /**
     * @return string[]
     */
    private static function rulePartSetters(): array
    {
        return [
            'setByDay',
            'setByMonthDay',
            'setByYearDay',
            'setByWeekNo',
            'setByMonth',
            'setBySetPos',
            'setByHour',
            'setByMinute',
            'setBySecond',
        ];
    }

    private static function createRule(): RecurrenceRule
    {
        return new RecurrenceRule(RecurrenceFrequency::DAILY());
    }
}
