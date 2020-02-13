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

use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Presentation\Component\Property\Value;

class DateTimeValue extends Value
{
    private const FORMAT_UTC_DATE_TIME = 'Ymd\\THis\\Z';
    private const FORMAT_NO_TIMEZONE = 'Ymd\\THis';
    private string $valueAsString;

    private function __construct(string $valueAsString)
    {
        $this->valueAsString = $valueAsString;
    }

    public static function fromTimestamp(Timestamp $timestamp): self
    {
        $dateTime = $timestamp->getDateTime()->setTimezone(new \DateTimeZone('UTC'));

        return new static($dateTime->format(self::FORMAT_UTC_DATE_TIME));
    }

    public static function fromDateTime(DateTime $dateTime): self
    {
        $format = self::FORMAT_NO_TIMEZONE;

        if ($dateTime->hasDateTimeZone()) {
            throw new \BadMethodCallException('not implemented yet');
        }

        return new static($dateTime->getDateTime()->format($format));
    }

    public function __toString(): string
    {
        return $this->valueAsString;
    }
}
