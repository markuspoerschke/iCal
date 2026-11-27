<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

use DateTimeInterface;
use Eluceo\iCal\Domain\Enum\RecurrenceFrequency;
use Eluceo\iCal\Domain\Enum\RecurrenceWeekday;
use InvalidArgumentException;

/**
 * Recurrence rule value object.
 *
 * @see https://tools.ietf.org/html/rfc5545#section-3.3.10
 * @see https://tools.ietf.org/html/rfc5545#section-3.8.5.3
 */
final class RecurrenceRule
{
    /**
     * Grammar of a single BYDAY value as defined in RFC 5545, section 3.3.10.
     *
     * An optional signed ordinal (1 to 53 or -53 to -1) followed by a weekday
     * abbreviation.
     */
    private const BY_DAY_PATTERN = '/\A[+-]?([1-9]|[1-4][0-9]|5[0-3])?(SU|MO|TU|WE|TH|FR|SA)\z/';

    private RecurrenceFrequency $frequency;
    private ?int $interval = null;
    private ?int $count = null;
    private ?DateTimeInterface $until = null;
    private ?RecurrenceWeekday $weekStartDay = null;

    /** @var string[]|null */
    private ?array $byDay = null;

    /** @var int[]|null */
    private ?array $byMonthDay = null;

    /** @var int[]|null */
    private ?array $byYearDay = null;

    /** @var int[]|null */
    private ?array $byWeekNo = null;

    /** @var int[]|null */
    private ?array $byMonth = null;

    /** @var int[]|null */
    private ?array $bySetPos = null;

    /** @var int[]|null */
    private ?array $byHour = null;

    /** @var int[]|null */
    private ?array $byMinute = null;

    /** @var int[]|null */
    private ?array $bySecond = null;

    public function __construct(RecurrenceFrequency $frequency)
    {
        $this->frequency = $frequency;
    }

    public function getFrequency(): RecurrenceFrequency
    {
        return $this->frequency;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function setInterval(int $interval): self
    {
        if ($interval < 1) {
            throw new InvalidArgumentException('Interval must be a positive integer.');
        }

        $this->interval = $interval;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * Set the COUNT rule part. Valid values are 1 or greater.
     *
     * COUNT and UNTIL must not occur in the same recurrence rule, therefore a
     * previously set UNTIL value is discarded.
     */
    public function setCount(int $count): self
    {
        if ($count < 1) {
            throw new InvalidArgumentException('Count must be a positive integer.');
        }

        $this->count = $count;
        $this->until = null;

        return $this;
    }

    public function getUntil(): ?DateTimeInterface
    {
        return $this->until;
    }

    /**
     * Set the UNTIL rule part.
     *
     * COUNT and UNTIL must not occur in the same recurrence rule, therefore a
     * previously set COUNT value is discarded.
     */
    public function setUntil(DateTimeInterface $until): self
    {
        $this->until = $until;
        $this->count = null;

        return $this;
    }

    public function getWeekStartDay(): ?RecurrenceWeekday
    {
        return $this->weekStartDay;
    }

    public function setWeekStartDay(RecurrenceWeekday $weekday): self
    {
        $this->weekStartDay = $weekday;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getByDay(): ?array
    {
        return $this->byDay;
    }

    /**
     * Set BYDAY rule part.
     *
     * Each value is a weekday abbreviation (e.g., "MO", "TU") optionally
     * preceded by an ordinal from 1 to 53 or -53 to -1 (e.g., "1MO", "-1FR").
     *
     * @param string[] $days
     */
    public function setByDay(array $days): self
    {
        $this->assertNotEmpty($days, 'BYDAY');

        foreach ($days as $day) {
            if (preg_match(self::BY_DAY_PATTERN, $day) !== 1) {
                throw new InvalidArgumentException(sprintf('The value "%s" is not a valid BYDAY value.', $day));
            }
        }

        $this->byDay = array_values($days);

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getByMonthDay(): ?array
    {
        return $this->byMonthDay;
    }

    /**
     * Set BYMONTHDAY rule part. Valid values are 1 to 31 or -31 to -1.
     *
     * @param int[] $days
     */
    public function setByMonthDay(array $days): self
    {
        $this->byMonthDay = $this->assertValidRange($days, 'BYMONTHDAY', 1, 31, true);

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getByYearDay(): ?array
    {
        return $this->byYearDay;
    }

    /**
     * Set BYYEARDAY rule part. Valid values are 1 to 366 or -366 to -1.
     *
     * @param int[] $days
     */
    public function setByYearDay(array $days): self
    {
        $this->byYearDay = $this->assertValidRange($days, 'BYYEARDAY', 1, 366, true);

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getByWeekNo(): ?array
    {
        return $this->byWeekNo;
    }

    /**
     * Set BYWEEKNO rule part. Valid values are 1 to 53 or -53 to -1.
     *
     * @param int[] $weeks
     */
    public function setByWeekNo(array $weeks): self
    {
        $this->byWeekNo = $this->assertValidRange($weeks, 'BYWEEKNO', 1, 53, true);

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getByMonth(): ?array
    {
        return $this->byMonth;
    }

    /**
     * Set BYMONTH rule part. Valid values are 1 to 12.
     *
     * @param int[] $months
     */
    public function setByMonth(array $months): self
    {
        $this->byMonth = $this->assertValidRange($months, 'BYMONTH', 1, 12, false);

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getBySetPos(): ?array
    {
        return $this->bySetPos;
    }

    /**
     * Set BYSETPOS rule part. Valid values are 1 to 366 or -366 to -1.
     *
     * @param int[] $positions
     */
    public function setBySetPos(array $positions): self
    {
        $this->bySetPos = $this->assertValidRange($positions, 'BYSETPOS', 1, 366, true);

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getByHour(): ?array
    {
        return $this->byHour;
    }

    /**
     * Set BYHOUR rule part. Valid values are 0 to 23.
     *
     * @param int[] $hours
     */
    public function setByHour(array $hours): self
    {
        $this->byHour = $this->assertValidRange($hours, 'BYHOUR', 0, 23, false);

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getByMinute(): ?array
    {
        return $this->byMinute;
    }

    /**
     * Set BYMINUTE rule part. Valid values are 0 to 59.
     *
     * @param int[] $minutes
     */
    public function setByMinute(array $minutes): self
    {
        $this->byMinute = $this->assertValidRange($minutes, 'BYMINUTE', 0, 59, false);

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getBySecond(): ?array
    {
        return $this->bySecond;
    }

    /**
     * Set BYSECOND rule part. Valid values are 0 to 60.
     *
     * @param int[] $seconds
     */
    public function setBySecond(array $seconds): self
    {
        $this->bySecond = $this->assertValidRange($seconds, 'BYSECOND', 0, 60, false);

        return $this;
    }

    /**
     * @param int[] $values
     *
     * @return int[]
     */
    private function assertValidRange(array $values, string $rulePart, int $min, int $max, bool $allowNegative): array
    {
        $this->assertNotEmpty($values, $rulePart);

        foreach ($values as $value) {
            $magnitude = $allowNegative ? abs($value) : $value;

            if ($magnitude < $min || $magnitude > $max) {
                throw new InvalidArgumentException(sprintf('The value %d is not a valid %s value. Valid values are %d to %d%s.', $value, $rulePart, $min, $max, $allowNegative ? sprintf(' or -%d to -%d', $max, $min) : ''));
            }
        }

        return array_values($values);
    }

    /**
     * @param array<mixed> $values
     */
    private function assertNotEmpty(array $values, string $rulePart): void
    {
        if ($values === []) {
            throw new InvalidArgumentException(sprintf('The %s rule part must contain at least one value.', $rulePart));
        }
    }
}
