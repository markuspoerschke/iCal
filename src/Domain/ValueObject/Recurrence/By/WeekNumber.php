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

final class WeekNumber
{
    /** @var array<int> */
    private array $weekNumbers;

    public function __construct(array $value)
    {
        $value = array_map('intval', $value);

        foreach ($value as $weekNumber) {
            if ($weekNumber < -53 || $weekNumber > 53 || $weekNumber === 0) {
                throw new InvalidArgumentException('Week number values must be between 1 and 53, or -1 and -53');
            }
        }

        $this->weekNumbers = $value;
    }

    public function __toString(): string
    {
        return 'BYWEEKNO=' . implode(',', $this->weekNumbers);
    }
}
