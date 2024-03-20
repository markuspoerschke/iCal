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
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Minute;
use InvalidArgumentException;

class MinuteTest extends TestCase
{
    public function testConstructorWithSingleMinute(): void
    {
        $minute = new Minute([15]);

        $this->assertInstanceOf(Minute::class, $minute);
        $this->assertSame('BYMINUTE=15', $minute->__toString());
    }

    public function testConstructorWithMultipleMinutes(): void
    {
        $minutes = new Minute([15, 30, 45]);

        $this->assertInstanceOf(Minute::class, $minutes);
        $this->assertSame('BYMINUTE=15,30,45', $minutes->__toString());
    }

    public function testConstructorWithInvalidMinuteValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Minute values must be between 0 and 59');

        new Minute([60]);
    }

    public function testConstructorWithInvalidMinuteArrayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Minute values must be between 0 and 59');

        new Minute([15, 60, 45]);
    }
}
