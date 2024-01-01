<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value\IntegerValue;
use PHPUnit\Framework\TestCase;

class IntegerValueTest extends TestCase
{
    public function testIntegerIsRendered()
    {
        $actual = (new IntegerValue(123))->__toString();
        self::assertSame('123', $actual);
    }
}
