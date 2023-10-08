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

final class Minute
{
    private array $minutes;

    public function __construct($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        $value = array_map('intval', $value);

        foreach ($value as $minute) {
            if ($minute < 0 || $minute > 59) {
                throw new InvalidArgumentException('Minute values must be between 0 and 59');
            }
        }

        $this->minutes = $value;
    }

    public function __toString(): string
    {
        return 'BYMINUTE=' . implode(',', $this->minutes);
    }
}
