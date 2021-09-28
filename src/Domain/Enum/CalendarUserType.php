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

final class CalendarUserType
{
    private static ?self $individual = null;
    private static ?self $group = null;
    private static ?self $resource = null;
    private static ?self $room = null;
    private static ?self $unknown = null;

    public static function INDIVIDUAL(): self
    {
        return self::$individual = self::$individual ?? new CalendarUserType();
    }

    public static function GROUP(): self
    {
        return self::$group = self::$group ?? new CalendarUserType();
    }

    public static function RESOURCE(): self
    {
        return self::$resource = self::$resource ?? new CalendarUserType();
    }

    public static function ROOM(): self
    {
        return self::$room = self::$room ?? new CalendarUserType();
    }

    public static function UNKNOWN(): self
    {
        return self::$unknown = self::$unknown ?? new CalendarUserType();
    }
}
