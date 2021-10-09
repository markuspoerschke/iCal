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

/**
 * @see https://datatracker.ietf.org/doc/html/rfc5545#section-3.8.4.1
 */
final class Attendee
{
    private EmailAddress $emailAddress;
    private ?string $calendarUserType = null;
    private ?bool $rsvp = null;
    private ?string $displayName;
    /*
    private ?string $role;
    private ?string $partStat;
    private ?string $delTo;
    private ?string $delFrom;
    private ?string $sentBy;
    private ?string $dir;
    private ?string $language; */

    /**
     * @var array<Member>
     */
    private array $members = [];

    public function __construct(
        EmailAddress $emailAddress,
        ?string $calendarUserType = null,
        ?string $displayName = null,
        bool $rsvp = null
    ) {
        $this->emailAddress = $emailAddress;
        $this->calendarUserType = $calendarUserType;
        $this->displayName = $displayName;
        $this->rsvp = $rsvp;
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

    public function getCalendarUserType(): string
    {
        assert($this->calendarUserType !== null);

        return $this->calendarUserType;
    }

    public function hasMembers(): bool
    {
        return !empty($this->members);
    }

    public function addMember(Member $member): self
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * @return array<Member>
     */
    public function getMembers(): array
    {
        return $this->members;
    }
}
