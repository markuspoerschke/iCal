<?php

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Interval;
use InvalidArgumentException;

class IntervalTest extends TestCase
{
    public function testConstructorWithValidInterval(): void
    {
        $interval = new Interval(2);

        $this->assertInstanceOf(Interval::class, $interval);
        $this->assertSame('INTERVAL=2', $interval->__toString());
    }

    public function testConstructorWithInvalidIntervalValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Interval must be greater than 0');

        new Interval(0);
    }

    public function testConstructorWithNegativeIntervalValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Interval must be greater than 0');

        new Interval(-2);
    }
}
