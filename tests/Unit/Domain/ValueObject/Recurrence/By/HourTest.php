<?php

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence\By;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Hour;
use InvalidArgumentException;

class HourTest extends TestCase
{
    public function testConstructorWithSingleHour(): void
    {
        $hour = new Hour(8);

        $this->assertInstanceOf(Hour::class, $hour);
        $this->assertSame('BYHOUR=8', $hour->__toString());
    }

    public function testConstructorWithMultipleHours(): void
    {
        $hours = new Hour([8, 12, 16]);

        $this->assertInstanceOf(Hour::class, $hours);
        $this->assertSame('BYHOUR=8,12,16', $hours->__toString());
    }

    public function testConstructorWithInvalidHourValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hour values must be between 0 and 23');

        new Hour(25);
    }

    public function testConstructorWithInvalidHourArrayValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hour values must be between 0 and 23');

        new Hour([8, 25, 16]);
    }
}
