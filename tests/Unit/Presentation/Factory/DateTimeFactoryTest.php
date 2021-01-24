<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Presentation\Factory;

use DateTimeImmutable as PhpDateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Presentation\Factory\DateTimeFactory;
use PHPUnit\Framework\TestCase;

class DateTimeFactoryTest extends TestCase
{
    public function testCreateProperty(): void
    {
        $dateTime = new DateTime(new PhpDateTimeImmutable('2021-01-22 11:12:13', new DateTimeZone('Europe/Berlin')), true);

        $property = (new DateTimeFactory())->createProperty('DTSTART', $dateTime);

        self::assertSame('DTSTART:TZID=Europe/Berlin:20210122T111213', $property->__toString());
    }
}
