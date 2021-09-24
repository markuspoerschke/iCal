<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

final class Attendee
{
    private EmailAddress $emailAddress;
    private ?string $displayName;
    private ?bool $rsvp;

    public function __construct(
        EmailAddress $emailAddress,
        ?string $displayName = null,
        ?bool $rsvp = false
    ) {
        $this->emailAddress = $emailAddress;
        $this->displayName = $displayName;
        $this->rsvp = $rsvp;
    }

    public function getEmailAddress(): EmailAddress
    {
        assert($this->emailAddress !== null);

        return $this->emailAddress;
    }

    public function hasDisplayName(): bool
    {
        return $this->displayName !== null;
    }

    public function getDisplayName(): string
    {
        assert($this->displayName !== null);

        return $this->displayName;
    }

    public function isRSVPenabled(): string
    {
        return $this->rsvp;
    }
}
