<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject\Recurrence;

use InvalidArgumentException;

final class Interval
{
    private int $interval;

    public function __construct(int $interval)
    {
        if ($interval < 1) {
            throw new InvalidArgumentException('Interval must be greater than 0');
        }

        $this->interval = $interval;
    }

    public function __toString(): string
    {
        return "INTERVAL={$this->interval}";
    }
}
