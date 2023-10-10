<?php

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence;

use DateTime as PhpDateTime;
use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Until;
use Eluceo\iCal\Domain\ValueObject\DateTime;

class UntilTest extends TestCase
{
    public function testConstructorWithValidDateTime(): void
    {
        $dateTime = new DateTime(new PhpDateTime('2023-12-31T12:00:00'), true);
        $until = new Until($dateTime);

        $this->assertInstanceOf(Until::class, $until);
        $this->assertSame('UNTIL=20231231T120000', $until->__toString());
    }
}
