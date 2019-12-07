<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

class MultiDay extends Occurrence
{
    private Date $firstDay;
    private Date $lastDay;

    public function __construct(Date $firstDay, Date $lastDay)
    {
        $this->firstDay = $firstDay;
        $this->lastDay = $lastDay;
    }

    public static function fromDates(Date $firstDay, Date $lastDay): self
    {
        return new static($firstDay, $lastDay);
    }

    public function getFirstDay(): Date
    {
        return $this->firstDay;
    }

    public function getLastDay(): Date
    {
        return $this->lastDay;
    }
}
