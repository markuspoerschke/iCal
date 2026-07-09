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

final class MonthDay
{
    /** @var array<int> */
    private array $monthDays;

    public function __construct(array $value)
    {
        $value = array_map('intval', $value);

        foreach ($value as $monthDay) {
            if ($monthDay < -31 || $monthDay > 31 || $monthDay === 0) {
                throw new InvalidArgumentException('Month day values must be between 1 and 31, or -1 and -31');
            }
        }

        $this->monthDays = $value;
    }

    public function __toString(): string
    {
        return 'BYMONTHDAY=' . implode(',', $this->monthDays);
    }
}
