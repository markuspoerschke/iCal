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

use InvalidArgumentException;

final class YearDay
{
    private array $yearDays;

    public function __construct($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        $value = array_map('intval', $value);

        foreach ($value as $weekNumber) {
            if ($weekNumber < -366 || $weekNumber > 366 || $weekNumber === 0) {
                throw new InvalidArgumentException('Week number values must be between 1 and 366, or -1 and -366');
            }
        }

        $this->yearDays = $value;
    }

    public function __toString(): string
    {
        return 'BYYEARDAY=' . implode(',', $this->yearDays);
    }
}
