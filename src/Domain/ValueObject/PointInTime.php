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

use DateInterval;
use DateTimeImmutable as PhpDateTimeImmutable;
use DateTimeInterface as PhpDateTimeInterface;
use Eluceo\iCal\Util\DateTimeImmutableFactory;

/**
 * @internal
 */
abstract class PointInTime
{
    private PhpDateTimeImmutable $dateTime;

    public function __construct(PhpDateTimeInterface $dateTime = null)
    {
        if ($dateTime === null) {
            $dateTime = new PhpDateTimeImmutable();
        }

        $this->dateTime = DateTimeImmutableFactory::createFromInterface($dateTime);
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
