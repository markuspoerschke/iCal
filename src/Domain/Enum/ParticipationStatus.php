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

final class ParticipationStatus
{
    private static ?self $needsAction = null;
    private static ?self $accepted = null;
    private static ?self $declined = null;
    private static ?self $tentative = null;
    private static ?self $delegated = null;
    private static ?self $completed = null;
    private static ?self $inProcess = null;

    public static function NEEDS_ACTION(): ParticipationStatus
    {
        return self::$needsAction ??= new ParticipationStatus();
    }

    public static function ACCEPTED(): ParticipationStatus
    {
        return self::$accepted ??= new ParticipationStatus();
    }

    public static function DECLINED(): ParticipationStatus
    {
        return self::$declined ??= new ParticipationStatus();
    }

    public static function TENTATIVE(): ParticipationStatus
    {
        return self::$tentative ??= new ParticipationStatus();
    }

    public static function DELEGATED(): ParticipationStatus
    {
        return self::$delegated ??= new ParticipationStatus();
    }

    public static function COMPLETED(): ParticipationStatus
    {
        return self::$completed ??= new ParticipationStatus();
    }

    public static function IN_PROCESS(): ParticipationStatus
    {
        return self::$inProcess ??= new ParticipationStatus();
    }
}
