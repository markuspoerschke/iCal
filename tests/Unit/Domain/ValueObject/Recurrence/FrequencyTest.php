<?php

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence;

use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Frequency;
use Eluceo\iCal\Domain\Enum\RecurrenceFrequency;

class FrequencyTest extends TestCase
{
    public function testConstructorWithValidFrequency(): void
    {
        $frequency = new Frequency(RecurrenceFrequency::DAILY());

        $this->assertInstanceOf(Frequency::class, $frequency);
        $this->assertSame('FREQ=DAILY', $frequency->__toString());
    }
}
