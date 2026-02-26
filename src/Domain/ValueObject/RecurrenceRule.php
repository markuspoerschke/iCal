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
class RecurrenceRule
{
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

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getUntil(): ?DateTimeInterface
    {
        return $this->until;
    }

    public function setUntil(DateTimeInterface $until): self
    {
        $this->until = $until;

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
     * Each value can be a weekday abbreviation (e.g., "MO", "TU") optionally
     * preceded by a positive or negative integer (e.g., "1MO", "-1FR").
     *
     * @param string[] $days
     */
    public function setByDay(array $days): self
    {
        $this->byDay = $days;

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
        $this->byMonthDay = $days;

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
        $this->byYearDay = $days;

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
        $this->byWeekNo = $weeks;

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
        $this->byMonth = $months;

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
        $this->bySetPos = $positions;

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
        $this->byHour = $hours;

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
        $this->byMinute = $minutes;

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
        $this->bySecond = $seconds;

        return $this;
    }
}
