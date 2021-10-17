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

use InvalidArgumentException;

final class TimeTransparency
{
    private const TRANSPARENT = 'TRANSPARENT';
    private const OPAQUE = 'OPAQUE';

    private string $transparency;

    private function __construct(string $transparency)
    {
        if (!in_array($transparency, [self::OPAQUE, self::TRANSPARENT])) {
            throw new InvalidArgumentException("$transparency is no valid time transparent option");
        }

        $this->transparency = $transparency;
    }

    public static function TRANSPARENT(): self
    {
        return new self(self::TRANSPARENT);
    }

    public static function OPAQUE(): self
    {
        return new self(self::OPAQUE);
    }

    public function isTransparent(): bool
    {
        return $this->transparency === self::TRANSPARENT;
    }

    public function __toString(): string
    {
        return $this->transparency;
    }
}
