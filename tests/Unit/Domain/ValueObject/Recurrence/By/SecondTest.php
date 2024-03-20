<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence\By;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Second;
use InvalidArgumentException;

class SecondTest extends TestCase
{
    public function testConstructorWithSingleSecond(): void
    {
        $second = new Second([30]);

        $this->assertInstanceOf(Second::class, $second);
        $this->assertSame('BYSECONDS=30', $second->__toString());
    }

    public function testConstructorWithMultipleSeconds(): void
    {
        $seconds = new Second([15, 30, 45]);

        $this->assertInstanceOf(Second::class, $seconds);
        $this->assertSame('BYSECONDS=15,30,45', $seconds->__toString());
    }

    public function testConstructorWithInvalidSecondValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Second values must be between 0 and 60');

        new Second([61]);
    }

    public function testConstructorWithInvalidSecondArrayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Second values must be between 0 and 60');

        new Second([15, 61, 45]);
    }
}
