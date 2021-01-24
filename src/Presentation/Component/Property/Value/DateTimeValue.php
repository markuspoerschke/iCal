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

use DateTimeZone;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\PointInTime;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Presentation\Component\Property\Value;
use InvalidArgumentException;

final class DateTimeValue extends Value
{
    private const FORMAT_UTC = 'Ymd\\THis\\Z';
    private const FORMAT = 'Ymd\\THis';
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

        return $dateTime->format(self::FORMAT_UTC);
    }

    private function convertDateTimeToString(DateTime $dateTime): string
    {
        return $dateTime->getDateTime()->format(self::FORMAT);
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
