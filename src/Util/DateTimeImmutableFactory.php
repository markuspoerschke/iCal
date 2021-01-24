<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Util;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * @internal
 */
final class DateTimeImmutableFactory
{
    public static function createFromInterface(DateTimeInterface $dateTime): DateTimeImmutable
    {
        if ($dateTime instanceof DateTimeImmutable) {
            return $dateTime;
        }

        return (new DateTimeImmutable('now', $dateTime->getTimezone()))
            ->setTimestamp($dateTime->getTimestamp());
    }
}
