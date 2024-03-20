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

use Eluceo\iCal\Domain\Enum\RecurrenceFrequency;

final class Frequency
{
    private RecurrenceFrequency $frequency;

    public function __construct(RecurrenceFrequency $frequency)
    {
        $this->frequency = $frequency;
    }

    public function __toString(): string
    {
        return "FREQ={$this->frequency}";
    }
}
