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
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\SetPosition;
use InvalidArgumentException;

class SetPositionTest extends TestCase
{
    public function testConstructorWithSinglePosition(): void
    {
        $position = new SetPosition(15);

        $this->assertInstanceOf(SetPosition::class, $position);
        $this->assertSame('BYSETPOS=15', $position->__toString());
    }

    public function testConstructorWithMultiplePositions(): void
    {
        $positions = new SetPosition([15, -1, -366]);

        $this->assertInstanceOf(SetPosition::class, $positions);
        $this->assertSame('BYSETPOS=15,-1,-366', $positions->__toString());
    }

    public function testConstructorWithInvalidPositionValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Position values must be between 1 and 366, or -1 and -366');

        new SetPosition(0);
    }

    public function testConstructorWithInvalidPositionArrayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Position values must be between 1 and 366, or -1 and -366');

        new SetPosition([15, 367, -367]);
    }
}
