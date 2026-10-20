<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Eluceo\iCal\Domain\ValueObject\RecurrenceRule;
use Eluceo\iCal\Presentation\Component\Property\Value;

/**
 * @see https://tools.ietf.org/html/rfc5545#section-3.3.10
 */
final class RecurrenceRuleValue extends Value
{
    private RecurrenceRule $recurrenceRule;
    private bool $untilAsDate;

    /**
     * @param bool $untilAsDate whether the UNTIL rule part must be rendered as a DATE value, which is
     *                          required when the DTSTART of the event is a DATE value as well
     */
    public function __construct(RecurrenceRule $recurrenceRule, bool $untilAsDate = false)
    {
        $this->recurrenceRule = $recurrenceRule;
        $this->untilAsDate = $untilAsDate;
    }

    public function __toString(): string
    {
        $parts = [];

        $parts[] = 'FREQ=' . $this->recurrenceRule->getFrequency();

        if ($this->recurrenceRule->getInterval() !== null) {
            $parts[] = 'INTERVAL=' . $this->recurrenceRule->getInterval();
        }

        if ($this->recurrenceRule->getCount() !== null) {
            $parts[] = 'COUNT=' . $this->recurrenceRule->getCount();
        }

        if ($this->recurrenceRule->getUntil() !== null) {
            $parts[] = 'UNTIL=' . $this->formatUntil($this->recurrenceRule->getUntil());
        }

        if ($this->recurrenceRule->getWeekStartDay() !== null) {
            $parts[] = 'WKST=' . $this->recurrenceRule->getWeekStartDay();
        }

        if ($this->recurrenceRule->getByDay() !== null) {
            $parts[] = 'BYDAY=' . implode(',', $this->recurrenceRule->getByDay());
        }

        if ($this->recurrenceRule->getByMonthDay() !== null) {
            $parts[] = 'BYMONTHDAY=' . implode(',', $this->recurrenceRule->getByMonthDay());
        }

        if ($this->recurrenceRule->getByYearDay() !== null) {
            $parts[] = 'BYYEARDAY=' . implode(',', $this->recurrenceRule->getByYearDay());
        }

        if ($this->recurrenceRule->getByWeekNo() !== null) {
            $parts[] = 'BYWEEKNO=' . implode(',', $this->recurrenceRule->getByWeekNo());
        }

        if ($this->recurrenceRule->getByMonth() !== null) {
            $parts[] = 'BYMONTH=' . implode(',', $this->recurrenceRule->getByMonth());
        }

        if ($this->recurrenceRule->getBySetPos() !== null) {
            $parts[] = 'BYSETPOS=' . implode(',', $this->recurrenceRule->getBySetPos());
        }

        if ($this->recurrenceRule->getByHour() !== null) {
            $parts[] = 'BYHOUR=' . implode(',', $this->recurrenceRule->getByHour());
        }

        if ($this->recurrenceRule->getByMinute() !== null) {
            $parts[] = 'BYMINUTE=' . implode(',', $this->recurrenceRule->getByMinute());
        }

        if ($this->recurrenceRule->getBySecond() !== null) {
            $parts[] = 'BYSECOND=' . implode(',', $this->recurrenceRule->getBySecond());
        }

        return implode(';', $parts);
    }

    private function formatUntil(DateTimeInterface $until): string
    {
        if ($this->untilAsDate) {
            return $until->format('Ymd');
        }

        return DateTimeImmutable::createFromInterface($until)
            ->setTimezone(new DateTimeZone('UTC'))
            ->format('Ymd\THis\Z');
    }
}
