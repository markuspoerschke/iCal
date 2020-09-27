<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use BadMethodCallException;
use DateTimeZone;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\PointInTime;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Presentation\Component\Property\Value;
use InvalidArgumentException;

final class DateTimeValue extends Value
{
    private const FORMAT_UTC_DATE_TIME = 'Ymd\\THis\\Z';
    private const FORMAT_NO_TIMEZONE = 'Ymd\\THis';
    private string $valueAsString;

    /**
     * @param Timestamp|DateTime $pointInTime
     */
    public function __construct(PointInTime $pointInTime)
    {
        $this->valueAsString = $this->convertPointInTime($pointInTime);
    }

    private function convertTimestampToString(Timestamp $timestamp): string
    {
        $dateTime = $timestamp->getDateTime()->setTimezone(new DateTimeZone('UTC'));

        return $dateTime->format(self::FORMAT_UTC_DATE_TIME);
    }

    private function convertDateTimeToString(DateTime $dateTime): string
    {
        $format = self::FORMAT_NO_TIMEZONE;

        if ($dateTime->hasDateTimeZone()) {
            throw new BadMethodCallException('not implemented yet');
        }

        return $dateTime->getDateTime()->format($format);
    }

    public function __toString(): string
    {
        return $this->valueAsString;
    }

    private function convertPointInTime(PointInTime $pointInTime): string
    {
        if ($pointInTime instanceof DateTime) {
            return $this->convertDateTimeToString($pointInTime);
        }

        if ($pointInTime instanceof Timestamp) {
            return $this->convertTimestampToString($pointInTime);
        }

        throw new InvalidArgumentException('Cannot convert object of type ' . get_class($pointInTime) . ' to string');
    }
}
