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

final class EventStatus
{
    private static ?self $cancelled = null;
    private static ?self $confirmed = null;
    private static ?self $tentative = null;

    public static function CANCELLED(): self
    {
        return self::$cancelled ??= new self();
    }

    public static function CONFIRMED(): self
    {
        return self::$confirmed ??= new self();
    }

    public static function TENTATIVE(): self
    {
        return self::$tentative ??= new self();
    }
}
