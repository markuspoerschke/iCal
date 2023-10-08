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

final class Second
{
    private array $seconds;

    public function __construct($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        $value = array_map('intval', $value);

        foreach ($value as $second) {
            if ($second < 0 || $second > 60) {
                throw new InvalidArgumentException('Second values must be between 0 and 60');
            }
        }

        $this->seconds = $value;
    }

    public function __toString(): string
    {
        return 'BYSECONDS=' . implode(',', $this->seconds);
    }
}
