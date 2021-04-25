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

final class Organizer
{
    private EmailAddress $emailAddress;
    private ?string $displayName;

    /**
     * The e-mail address of another user that is acting on behalf of the "Organizer".
     */
    private ?EmailAddress $sentBy;

    /**
     * To specify reference to a directory entry associated wit the calendar user specified by the property.
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.2.6
     */
    private ?Uri $directoryEntry;

    public function __construct(
        EmailAddress $emailAddress,
        ?string $displayName = null,
        ?Uri $directoryEntry = null,
        ?EmailAddress $sentBy = null
    ) {
        $this->emailAddress = $emailAddress;
        $this->displayName = $displayName;
        $this->directoryEntry = $directoryEntry;
        $this->sentBy = $sentBy;
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

    public function isSentInBehalfOf(): bool
    {
        return $this->sentBy !== null;
    }

    public function getSentBy(): EmailAddress
    {
        assert($this->sentBy !== null);

        return $this->sentBy;
    }

    public function hasDirectoryEntry(): bool
    {
        return $this->directoryEntry !== null;
    }

    public function getDirectoryEntry(): Uri
    {
        assert($this->directoryEntry !== null);

        return $this->directoryEntry;
    }
}
