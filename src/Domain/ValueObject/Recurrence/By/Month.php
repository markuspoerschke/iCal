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

final class Month
{
    /** @var array<int> */
    private array $months;

    public function __construct(array $value)
    {
        $value = array_map('intval', $value);

        foreach ($value as $month) {
            if ($month < 1 || $month > 12) {
                throw new InvalidArgumentException('Month values must be between 1 and 12');
            }
        }

        $this->months = $value;
    }

    public function __toString(): string
    {
        return 'BYMONTH=' . implode(',', $this->months);
    }
}
