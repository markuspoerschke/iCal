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

use Eluceo\iCal\Presentation\Component\Property\Value;

final class UtcOffsetValue extends Value
{
    private string $prefix;
    private int $hours;
    private int $minutes;

    public function __construct(string $prefix, int $hours, int $minutes)
    {
        $this->prefix = $prefix;
        $this->hours = $hours;
        $this->minutes = $minutes;
    }

    public static function fromSeconds(int $seconds): self
    {
        $prefix = ($seconds >= 0) ? '+' : '-';
        $seconds = abs($seconds);

        $hours = intval($seconds / (60 * 60));
        $minutes = intval($seconds / 60 - $hours * 60);

        return new self($prefix, $hours, $minutes);
    }

    public function __toString(): string
    {
        return
            $this->prefix
            . str_pad((string) $this->hours, 2, '0', STR_PAD_LEFT)
            . str_pad((string) $this->minutes, 2, '0', STR_PAD_LEFT);
    }
}
