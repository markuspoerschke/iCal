<?php

namespace Eluceo\iCal\Util;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DateTimeImmutableFactoryTest extends TestCase
{
    public function testDateTimeIsConvertedToImmutableObject()
    {
        $input = new DateTime();
        $actual = DateTimeImmutableFactory::createFromInterface($input);

        static::assertInstanceOf(DateTimeImmutable::class, $actual);
        static::assertSame($input->format(DATE_COOKIE), $actual->format(DATE_COOKIE));
    }
}
