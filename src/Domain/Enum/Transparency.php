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

final class Transparency
{
    private static ?self $opaque = null;
    private static ?self $transparent = null;

    public static function OPAQUE(): self
    {
        return self::$opaque ??= new self();
    }

    public static function TRANSPARENT(): self
    {
        return self::$transparent ??= new self();
    }
}
