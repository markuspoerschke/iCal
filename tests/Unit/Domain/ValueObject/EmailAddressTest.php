<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject;

use Eluceo\iCal\Domain\ValueObject\EmailAddress;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailAddressTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new EmailAddress('example@example.com');

        self::assertEquals('mailto:example@example.com', $email->toUri()->getUri());
    }

    public function testInvalidEmail(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('example@example@example.com is no valid e-mail address');

        new EmailAddress('example@example@example.com');
    }
}
