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
     * Accepts one or more recurrence days
     *
     * For example:
     *
     *   [RecurrenceWeekDay::monday(), RecurrenceWeekDay::sunday(-3)]
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

        foreach ($days as $day) {
            if (!is_a($day, RecurrenceWeekDay::class)) {
                throw new \InvalidArgumentException('Day must be an instance of RecurrenceWeekDay');
            }
        }

        $this->days = $days;
    }

    public function __toString(): string
    {
        return 'BYDAY=' . implode(',', $this->days);
    }
}
