<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

use DateInterval;
use DateTimeImmutable as PhpDateTimeImmutable;

/**
 * @internal
 */
abstract class PointInTime
{
    private PhpDateTimeImmutable $dateTime;

    protected function __construct(PhpDateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function getDateTime(): PhpDateTimeImmutable
    {
        return $this->dateTime;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType
     */
    public function add(DateInterval $interval): self
    {
        $new = clone $this;
        $new->dateTime = $new->dateTime->add($interval);

        return $new;
    }
}
