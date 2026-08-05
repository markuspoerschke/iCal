<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Enum;

final class TodoStatus
{
    private static ?self $cancelled = null;
    private static ?self $completed = null;
    private static ?self $inProcess = null;
    private static ?self $needsAction = null;

    public static function CANCELLED(): self
    {
        return self::$cancelled ??= new self();
    }

    public static function COMPLETED(): self
    {
        return self::$completed ??= new self();
    }

    public static function IN_PROCESS(): self
    {
        return self::$inProcess ??= new self();
    }

    public static function NEEDS_ACTION(): self
    {
        return self::$needsAction ??= new self();
    }
}
