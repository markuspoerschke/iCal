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

use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Presentation\Component\Property\Value\DateTimeValue;

class Until
{
    private DateTime $exclusions;

    public function __construct(DateTime $value)
    {
        $this->exclusions = $value;
    }

    public function __toString(): string
    {
        return 'UNTIL=' . (new DateTimeValue($this->exclusions));
    }
}
