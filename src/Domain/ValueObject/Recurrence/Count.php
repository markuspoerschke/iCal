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

final class Count
{
    private int $count;

    public function __construct(int $count)
    {
        if ($count < 1) {
            throw new InvalidArgumentException('Count must be greater than 0');
        }

        $this->count = $count;
    }

    public function __toString(): string
    {
        return "COUNT={$this->count}";
    }
}
