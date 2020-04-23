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

use DateTimeImmutable as PhpDateTimeImmutable;
use DateTimeInterface as PhpDateTimeInterface;

class Timestamp extends PointInTime
{
    public static function fromDateTimeInterface(PhpDateTimeInterface $dateTime): self
    {
        $dateTime = PhpDateTimeImmutable::createFromFormat(
            PhpDateTimeInterface::ATOM,
            $dateTime->format(PhpDateTimeInterface::ATOM), $dateTime->getTimezone()
        );

        if ($dateTime === false) {
            throw new \RuntimeException('Unexpected date time value.');
        }

        return new static($dateTime);
    }

    public static function fromCurrentTime(): self
    {
        return static::fromDateTimeInterface(new PhpDateTimeImmutable());
    }
}
