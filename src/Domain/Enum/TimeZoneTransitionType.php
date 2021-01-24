<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Enum;

final class TimeZoneTransitionType
{
    private static ?self $daylight = null;
    private static ?self $standard = null;

    public static function DAYLIGHT(): self
    {
        return self::$daylight = self::$daylight ?? new TimeZoneTransitionType();
    }

    public static function STANDARD(): self
    {
        return self::$standard = self::$standard ?? new TimeZoneTransitionType();
    }
}
