<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

final class Member
{
    private ?EmailAddress $emailAddress = null;

    public function __construct(EmailAddress $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    public function getEmailAddress(): EmailAddress
    {
        assert($this->emailAddress !== null);

        return $this->emailAddress;
    }
}
