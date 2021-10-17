<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\Enum;

use Eluceo\iCal\Domain\Enum\TimeTransparency;
use PHPUnit\Framework\TestCase;

class TimeTransparencyTest extends TestCase
{
    public function testToStringIsCoherentWithNamedConstructors()
    {
        self::assertSame('OPAQUE', (string) TimeTransparency::OPAQUE());
        self::assertSame('TRANSPARENT', (string) TimeTransparency::TRANSPARENT());
    }
}
