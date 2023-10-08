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

final class Hour
{
    private array $hours;

    public function __construct($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        $value = array_map('intval', $value);

        foreach ($value as $hour) {
            if ($hour < 0 || $hour > 23) {
                throw new InvalidArgumentException('Hour values must be between 0 and 23');
            }
        }

        $this->hours = $value;
    }

    public function __toString(): string
    {
        return 'BYHOUR=' . implode(',', $this->hours);
    }
}
