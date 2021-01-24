<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
