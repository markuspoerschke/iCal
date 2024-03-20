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
use InvalidArgumentException;

class Exclusion
{
    /** @var array<DateTime> */
    private array $exclusions;

    public function __construct(array $value)
    {
        foreach ($value as $exclusion) {
            if (!$exclusion instanceof DateTime) {
                throw new InvalidArgumentException('Values must be DateTime objects');
            }
        }
        $this->exclusions = $value;
    }

    public function __toString(): string
    {
        return implode(',', array_map(static function ($ex) {
            return (string)(new DateTimeValue($ex));
        }, $this->exclusions));
    }
}
