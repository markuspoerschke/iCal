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

final class SetPosition
{
    /** @var array<int> */
    private array $positions;

    public function __construct(array $value)
    {
        $value = array_map('intval', $value);

        foreach ($value as $position) {
            if ($position < -366 || $position > 366 || $position === 0) {
                throw new InvalidArgumentException('Position values must be between 1 and 366, or -1 and -366');
            }
        }

        $this->positions = $value;
    }

    public function __toString(): string
    {
        return 'BYSETPOS=' . implode(',', $this->positions);
    }
}
