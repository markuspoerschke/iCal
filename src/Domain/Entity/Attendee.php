<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Entity;

use Eluceo\iCal\Domain\Enum\CalendarUserType;
use Eluceo\iCal\Domain\Enum\ParticipationStatus;
use Eluceo\iCal\Domain\Enum\RoleType;
use Eluceo\iCal\Domain\ValueObject\EmailAddress;
use Eluceo\iCal\Domain\ValueObject\Member;
use Eluceo\iCal\Domain\ValueObject\Uri;

/**
 * @see https://datatracker.ietf.org/doc/html/rfc5545#section-3.8.4.1
 */
final class Attendee
{
    private EmailAddress $emailAddress;
    private ?CalendarUserType $calendarUserType = null;
    private ?RoleType $role = null;
    private ?ParticipationStatus $participationStatus = null;
    private ?bool $rsvp = null;
    private ?string $displayName = null;
    private ?Uri $directoryEntry = null;
    private ?string $language = null;

    /**
     * @var array<Member>
     */
    private array $members = [];

    /**
     * @var array<EmailAddress>
     */
    private array $delegatedTo = [];

    /**
     * @var array<EmailAddress>
     */
    private array $delegatedFrom = [];

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

    public function setCalendarUserType(CalendarUserType $calendarUserType): self
    {
        $this->calendarUserType = $calendarUserType;

        return $this;
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

    public function setRole(RoleType $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function hasRole(): bool
    {
        return $this->role !== null;
    }

    public function getRole(): RoleType
    {
        assert($this->role !== null);

        return $this->role;
    }

    public function setParticipationStatus(ParticipationStatus $participationStatus): self
    {
        $this->participationStatus = $participationStatus;

        return $this;
    }

    public function hasParticipationStatus(): bool
    {
        return $this->participationStatus !== null;
    }

    public function getParticipationStatus(): ParticipationStatus
    {
        assert($this->participationStatus !== null);

        return $this->participationStatus;
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
        $this->delegatedTo[] = $delegatedTo;

        return $this;
    }

    public function hasDelegatedTo(): bool
    {
        return !empty($this->delegatedTo);
    }

    /**
     * @return array<EmailAddress>
     */
    public function getDelegatedTo(): array
    {
        return $this->delegatedTo;
    }

    public function addDelegatedFrom(EmailAddress $delegatedFrom): self
    {
        $this->delegatedFrom[] = $delegatedFrom;

        return $this;
    }

    public function hasDelegatedFrom(): bool
    {
        return !empty($this->delegatedFrom);
    }

    /**
     * @return array<EmailAddress>
     */
    public function getDelegatedFrom(): array
    {
        return $this->delegatedFrom;
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
        return $this->directoryEntry !== null;
    }

    public function getDirectoryEntryReference(): Uri
    {
        assert($this->directoryEntry !== null);

        return $this->directoryEntry;
    }

    public function setDirectoryEntryReference(Uri $directoryEntry): self
    {
        $this->directoryEntry = $directoryEntry;

        return $this;
    }

    public function hasLanguage(): bool
    {
        return $this->language !== null;
    }

    public function getLanguage(): string
    {
        assert($this->language !== null);

        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }
}
