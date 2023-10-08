<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Entity;


use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Count;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Exclusion;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Frequency;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Interval;
use Eluceo\iCal\Domain\ValueObject\Recurrence\WeekStart;
use Eluceo\iCal\Presentation\Component\Property\Value\DateTimeValue;
use InvalidArgumentException;

class RecurrenceRule
{
    private ?DateTime $until = null;
    private ?Frequency $frequency = null;
    private ?Count $count = null;
    private ?Interval $interval = null;
    private ?WeekStart $weekStart = null;
    private ?By $by = null;
    private ?Exclusion $exclusions = null;

    public function getUntil(): ?DateTime
    {
        return $this->until;
    }

    public function hasUntil(): bool
    {
        return $this->until !== null;
    }

    public function setUntil(?DateTime $until): self
    {
        $this->until = $until;
        return $this;
    }

    public function unsetUntil(): self
    {
        $this->until = null;
        return $this;
    }

    public function getFrequency(): ?Frequency
    {
        return $this->frequency;
    }

    public function hasFrequency(): bool
    {
        return $this->frequency !== null;
    }

    public function setFrequency(?Frequency $frequency): self
    {
        $this->frequency = $frequency;
        return $this;
    }

    public function unsetFrequency(): self
    {
        $this->frequency = null;
        return $this;
    }

    public function getCount(): ?Count
    {
        return $this->count;
    }

    public function hasCount(): bool
    {
        return $this->count !== null;
    }

    public function setCount(?Count $count): self
    {
        $this->count = $count;
        return $this;
    }

    public function unsetCount(): self
    {
        $this->count = null;
        return $this;
    }

    public function getInterval(): ?Interval
    {
        return $this->interval;
    }

    public function hasInterval(): bool
    {
        return $this->interval !== null;
    }

    public function setInterval(?Interval $interval): self
    {
        $this->interval = $interval;
        return $this;
    }

    public function unsetInterval(): self
    {
        $this->interval = null;
        return $this;
    }

    public function getWeekStart(): ?WeekStart
    {
        return $this->weekStart;
    }

    public function hasWeekStart(): bool
    {
        return $this->weekStart !== null;
    }

    public function setWeekStart(?WeekStart $weekStart): self
    {
        $this->weekStart = $weekStart;
        return $this;
    }

    public function unsetWeekStart(): self
    {
        $this->weekStart = null;
        return $this;
    }

    public function getBy(): ?By
    {
        return $this->by;
    }

    public function hasBy(): bool
    {
        return !empty($this->by);
    }

    public function setBy(By $by): self
    {
        $this->by = $by;
        return $this;
    }

    public function unsetBy(): self
    {
        $this->by = null;
        return $this;
    }

    public function getExclusions(): ?Exclusion
    {
        return $this->exclusions;
    }

    public function hasExclusions(): bool
    {
        return !empty($this->exclusions);
    }

    public function setExclusions(Exclusion $exclusions): self
    {
        $this->exclusions = $exclusions;
        return $this;
    }

    public function unsetExclusions(): self
    {
        $this->exclusions = null;
        return $this;
    }

    public function __toString(): string
    {
        if (
            !$this->hasUntil()
            && !$this->hasFrequency()
            && !$this->hasCount()
            && !$this->hasInterval()
            && !$this->hasInterval()
            && !$this->hasWeekStart()
            && !$this->hasBy()
        ) {
            return '';
        }

        $parts = [
            $this->hasUntil() ? new DateTimeValue($this->getUntil()) : null,
            $this->getFrequency(),
            $this->getCount(),
            $this->getInterval(),
            $this->getWeekStart(),
            $this->getBy()
        ];

        return implode(';', array_map('strval',
            array_filter($parts, static function ($part) {
                return !empty($part);
            })
        ));
    }
}
