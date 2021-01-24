<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Presentation\Component\Property\Value;

final class DateValue extends Value
{
    private const FORMAT = 'Ymd';
    private string $valueAsString;

    public function __construct(Date $date)
    {
        $this->valueAsString = $date->getDateTime()->format(self::FORMAT);
    }

    public function __toString(): string
    {
        return $this->valueAsString;
    }
}
