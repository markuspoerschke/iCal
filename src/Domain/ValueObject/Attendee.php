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
    private ?string $role = null;
    private ?string $partStat = null;
    private ?bool $rsvp = null;

    private ?string $displayName = null;
    private ?Uri $dir = null;
    private ?string $language = null;

    /**
     * @var array<Member>
     */
    private array $members = [];

    /**
     * @var array<EmailAddress>
     */
    private array $delTo = [];

    /**
     * @var array<EmailAddress>
     */
    private array $delFrom = [];

    /**
     * @var array<EmailAddress>
     */
    private array $sentBy = [];

    public function __construct(
        EmailAddress $emailAddress
    ) {
        $this->emailAddress = $emailAddress;
    }

    public function getEmailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function setCalendarUserType(string $calendarUserType): self
    {
        $this->calendarUserType = $calendarUserType;

        return $this;
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

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function hasRole(): bool
    {
        return $this->role !== null;
    }

    public function getRole(): string
    {
        assert($this->role !== null);

        return $this->role;
    }

    public function setParticipationStatus(string $partStat): self
    {
        $this->partStat = $partStat;

        return $this;
    }

    public function hasParticipationStatus(): bool
    {
        return $this->partStat !== null;
    }

    public function getParticipationStatus(): string
    {
        assert($this->partStat !== null);

        return $this->partStat;
    }

    public function setResponseNeededFromAttendee(bool $res): self
    {
        $this->rsvp = $res;

        return $this;
    }

    public function isRSVPenabled(): bool
    {
        return $this->rsvp !== null;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
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

    public function addDelegatedTo(EmailAddress $delegatedTo): self
    {
        $this->delTo[] = $delegatedTo;

        return $this;
    }

    public function hasDelegatedTo(): bool
    {
        return !empty($this->delTo);
    }

    /**
     * @return array<EmailAddress>
     */
    public function getDelegatedTo(): array
    {
        return $this->delTo;
    }

    public function addDelegatedFrom(EmailAddress $delegatedFrom): self
    {
        $this->delFrom[] = $delegatedFrom;

        return $this;
    }

    public function hasDelegatedFrom(): bool
    {
        return !empty($this->delFrom);
    }

    /**
     * @return array<EmailAddress>
     */
    public function getDelegatedFrom(): array
    {
        return $this->delFrom;
    }

    public function addSentBy(EmailAddress $sentBy): self
    {
        $this->sentBy[] = $sentBy;

        return $this;
    }

    public function hasSentBy(): bool
    {
        return !empty($this->sentBy);
    }

    /**
     * @return array<EmailAddress>
     */
    public function getSentBy(): array
    {
        return $this->sentBy;
    }

    public function hasDirectoryEntryReference(): bool
    {
        return $this->dir !== null;
    }

    public function getDirectoryEntryReference(): Uri
    {
        assert($this->dir !== null);

        return $this->dir;
    }

    public function setDirectoryEntryReference(Uri $dir): self
    {
        $this->dir = $dir;

        return $this;
    }
}
