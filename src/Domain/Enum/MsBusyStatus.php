<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Enum;

final class MsBusyStatus
{
    private static ?self $free = null;
    private static ?self $tentative = null;
    private static ?self $busy = null;
    private static ?self $oof = null;

    public static function FREE(): self
    {
        return self::$free ??= new self();
    }

    public static function TENTATIVE(): self
    {
        return self::$tentative ??= new self();
    }

    public static function BUSY(): self
    {
        return self::$busy ??= new self();
    }

    public static function OOF(): self
    {
        return self::$oof ??= new self();
    }
}
