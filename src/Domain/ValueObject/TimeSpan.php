<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

final class TimeSpan extends Occurrence
{
    private DateTime $begin;
    private DateTime $end;

    public function __construct(DateTime $begin, DateTime $end)
    {
        $this->begin = $begin;
        $this->end = $end;
    }

    public static function create(DateTime $begin, DateTime $end): self
    {
        return new static($begin, $end);
    }

    public function getBegin(): DateTime
    {
        return $this->begin;
    }

    public function getEnd(): DateTime
    {
        return $this->end;
    }
}
