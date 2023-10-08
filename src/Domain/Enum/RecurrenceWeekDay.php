<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Enum;

final class RecurrenceWeekDay extends RecurrenceEnum
{
    public const SUNDAY = 'SU';
    public const MONDAY = 'MO';
    public const TUESDAY = 'TU';
    public const WEDNESDAY = 'WE';
    public const THURSDAY = 'TH';
    public const FRIDAY = 'FR';
    public const SATURDAY = 'SA';

    public static function sunday(): self
    {
        return new self(self::SUNDAY);
    }

    public static function monday(): self
    {
        return new self(self::MONDAY);
    }

    public static function tuesday(): self
    {
        return new self(self::TUESDAY);
    }

    public static function wednesday(): self
    {
        return new self(self::WEDNESDAY);
    }

    public static function thursday(): self
    {
        return new self(self::THURSDAY);
    }

    public static function friday(): self
    {
        return new self(self::FRIDAY);
    }

    public static function saturday(): self
    {
        return new self(self::SATURDAY);
    }
}
