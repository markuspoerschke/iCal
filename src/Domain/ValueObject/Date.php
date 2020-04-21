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
use DateTimeInterface as PhpDateTimeInterface;
use InvalidArgumentException;

final class Date extends PointInTime
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

    public static function fromCurrentDay(): self
    {
        return static::fromDateTimeInterface(new PhpDateTimeImmutable());
    }

    public function add(DateInterval $interval): self
    {
        if (
            $interval->h > 0
            || $interval->i > 0
            || $interval->s > 0
            || $interval->f > 0
        ) {
            throw new InvalidArgumentException('Cannot add time interval to a date.');
        }

        $new = parent::add($interval);
        assert($new instanceof static);

        return $new;
    }
}
