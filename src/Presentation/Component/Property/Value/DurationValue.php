<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2025 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use DateInterval;
use DateTimeImmutable;
use Eluceo\iCal\Presentation\Component\Property\Value;

final class DurationValue extends Value
{
    private DateInterval $duration;

    public function __construct(DateInterval $duration)
    {
        $this->duration = $duration;
    }

    public function __toString(): string
    {
        $duration = $this->getNormalizedDateInterval();
        $days = abs($duration->days);
        $hours = abs($duration->h);
        $minutes = abs($duration->i);
        $seconds = abs($duration->s);
        if ($days + $hours + $minutes + $seconds === 0) {
            return 'PT0S';
        }

        $durationAsString = $duration->invert === 1 ? '-P' : 'P';

        if ($days > 0) {
            $durationAsString .= $days . 'D';
        }

        if ($hours > 0 || $minutes > 0 || $seconds > 0) {
            $durationAsString .= 'T';

            if ($hours > 0) {
                $durationAsString .= $hours . 'H';
            }

            if ($minutes > 0) {
                $durationAsString .= $minutes . 'M';
            }

            if ($seconds > 0) {
                $durationAsString .= $seconds . 'S';
            }
        }

        return $durationAsString;
    }

    /**
     * Normalizes the date interval.
     *
     * If the date interval is created from string,
     * then interval and days property are empty.
     *
     * Only date intervals that are created as a result from a diff
     * of two dates contains the correct values.
     *
     * @see https://www.php.net/manual/de/class.dateinterval.php
     */
    private function getNormalizedDateInterval(): DateInterval
    {
        $baseDate = (new DateTimeImmutable())->setTimestamp(0);
        $nextDate = $baseDate->sub($this->duration);

        return $nextDate->diff($baseDate);
    }
}
