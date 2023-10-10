<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Count;
use InvalidArgumentException;

class CountTest extends TestCase
{
    public function testConstructorWithValidCount(): void
    {
        $count = new Count(5);

        $this->assertInstanceOf(Count::class, $count);
        $this->assertSame('COUNT=5', $count->__toString());
    }

    public function testConstructorWithInvalidCountValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Count must be greater than 0');

        new Count(0);
    }

    public function testConstructorWithNegativeCountValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Count must be greater than 0');

        new Count(-5);
    }
}
