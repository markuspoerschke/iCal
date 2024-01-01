<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
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
        return self::$individual ??= new self();
    }

    public static function GROUP(): self
    {
        return self::$group ??= new self();
    }

    public static function RESOURCE(): self
    {
        return self::$resource ??= new self();
    }

    public static function ROOM(): self
    {
        return self::$room ??= new self();
    }

    public static function UNKNOWN(): self
    {
        return self::$unknown ??= new self();
    }
}
