<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Presentation\Component\Property\Value;

class DateValue extends Value
{
    private const FORMAT = 'Ymd';
    private string $valueAsString;

    private function __construct(string $valueAsString)
    {
        $this->valueAsString = $valueAsString;
    }

    public static function fromDate(Date $date): self
    {
        return new static($date->getDateTime()->format(self::FORMAT));
    }

    public function __toString(): string
    {
        return $this->valueAsString;
    }
}
