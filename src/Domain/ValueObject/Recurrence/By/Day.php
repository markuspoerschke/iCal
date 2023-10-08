<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject\Recurrence\By;

use Eluceo\iCal\Domain\Enum\RecurrenceWeekDay;

class Day
{
    private array $days;

    /**
     * Accepts one or more recurrence days.
     *
     * If the day is an index, an offset is expected as the value, such as:
     *
     *   [RecurrenceWeekDay::monday(), RecurrenceWeekDay::sunday() => -3]
     *
     * If the offset is given, it must be between -53 and 53.
     *
     * @param $days
     */
    public function __construct($days)
    {
        if (!is_array($days)) {
            $days = [$days];
        }

        foreach ($days as $key => $value) {
            if (is_numeric($value)) {
                $value = (int)$value;
                if ($value < -53 || $value > 53) {
                    throw new \InvalidArgumentException('Day offsets must be between -53 and 53');
                }
                if (!is_a($key, RecurrenceWeekDay::class)) {
                    throw new \InvalidArgumentException('Day must be an instance of RecurrenceWeekDay');
                }
                $days[$key] = $value;
            } elseif (!is_a($value, RecurrenceWeekDay::class)) {
                throw new \InvalidArgumentException('Day must be an instance of RecurrenceWeekDay');
            }
        }

        $this->days = $days;
    }

    public function __toString(): string
    {
        $parts = [];
        foreach ($this->days as $key => $value) {
            if (is_numeric($value)) {
                $parts[] = "{$key}{$value}";
            } else {
                $parts[] = (string)$value;
            }
        }
        return 'BYDAY=' . implode(',', $parts);
    }
}
