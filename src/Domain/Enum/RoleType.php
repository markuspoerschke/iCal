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

final class RoleType
{
    private static ?self $chair = null;
    private static ?self $reqParticipant = null;
    private static ?self $optParticipant = null;
    private static ?self $nonParticipant = null;

    public static function CHAIR(): self
    {
        return self::$chair ??= new RoleType();
    }

    public static function REQ_PARTICIPANT(): self
    {
        return self::$reqParticipant ??= new RoleType();
    }

    public static function OPT_PARTICIPANT(): self
    {
        return self::$optParticipant ??= new RoleType();
    }

    public static function NON_PARTICIPANT(): self
    {
        return self::$nonParticipant ??= new RoleType();
    }
}
