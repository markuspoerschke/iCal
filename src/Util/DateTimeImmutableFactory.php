<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Util;

use DateTimeImmutable;
use DateTimeInterface;
use RuntimeException;

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

        $dateTime = DateTimeImmutable::createFromFormat(
            DateTimeInterface::ATOM,
            $dateTime->format(DateTimeInterface::ATOM), $dateTime->getTimezone()
        );

        if ($dateTime === false) {
            throw new RuntimeException('Unexpected date time value.');
        }

        return $dateTime;
    }
}
