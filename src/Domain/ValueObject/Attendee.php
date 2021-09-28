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

use Eluceo\iCal\Domain\Enum\CalendarUserType;

final class Attendee
{
    private EmailAddress $emailAddress;
    private ?CalendarUserType $calendarUserType = null;
    private ?bool $rsvp = null;
    private ?string $displayName;
    /*  private ?string $member;
     private ?string $role;
     private ?string $partStat;
     private ?string $delTo;
     private ?string $delFrom;
     private ?string $sentBy;
     private ?string $dir;
     private ?string $language; */
    // TODO: Implement

    public function __construct(
        EmailAddress $emailAddress,
        ?string $displayName = null,
        bool $rsvp = null,
        ?CalendarUserType $calendarUserType = null
    ) {
        $this->emailAddress = $emailAddress;
        $this->displayName = $displayName;
        $this->rsvp = $rsvp;
        $this->calendarUserType = $calendarUserType;
    }

    public function getEmailAddress(): EmailAddress
    {
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

    public function isRSVPenabled(): bool
    {
        return $this->rsvp !== null;
    }

    public function hasCalendarUserType(): bool
    {
        return $this->calendarUserType !== null;
    }

    public function getCalendarUserType(): CalendarUserType
    {
        assert($this->calendarUserType !== null);

        return $this->calendarUserType;
    }
}
