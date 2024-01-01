<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Entity;

use Eluceo\iCal\Domain\Enum\EventStatus;
use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\Category;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\Occurrence;
use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;
use Eluceo\iCal\Domain\ValueObject\Uri;

class Event
{
    private UniqueIdentifier $uniqueIdentifier;
    private Timestamp $touchedAt;
    private ?string $summary = null;
    private ?string $description = null;
    private ?Uri $url = null;
    private ?Occurrence $occurrence = null;
    private ?Location $location = null;
    private ?Organizer $organizer = null;
    private ?Timestamp $lastModified = null;
    private ?EventStatus $status = null;

    /**
     * @var array<Attendee>
     */
    private array $attendees = [];

    /**
     * @var array<Alarm>
     */
    private array $alarms = [];

    /**
     * @var array<Attachment>
     */
    private array $attachments = [];

    /**
     * @var array<Category>
     */
    private array $categories = [];

    public function __construct(UniqueIdentifier $uniqueIdentifier = null)
    {
        $this->uniqueIdentifier = $uniqueIdentifier ?? UniqueIdentifier::createRandom();
        $this->touchedAt = new Timestamp();
    }

    public function getUniqueIdentifier(): ?UniqueIdentifier
    {
        return $this->uniqueIdentifier;
    }

    public function getTouchedAt(): Timestamp
    {
        return $this->touchedAt;
    }

    public function touch(Timestamp $dateTime = null): self
    {
        $this->touchedAt = $dateTime ?? new Timestamp();

        return $this;
    }

    public function getSummary(): string
    {
        assert($this->summary !== null);

        return $this->summary;
    }

    public function hasSummary(): bool
    {
        return $this->summary !== null;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function unsetSummary(): self
    {
        $this->summary = null;

        return $this;
    }

    public function getDescription(): string
    {
        assert($this->description !== null);

        return $this->description;
    }

    public function hasDescription(): bool
    {
        return $this->description !== null;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function unsetDescription(): self
    {
        $this->description = null;

        return $this;
    }

    public function getUrl(): Uri
    {
        assert($this->url !== null);

        return $this->url;
    }

    public function hasUrl(): bool
    {
        return $this->url !== null;
    }

    public function setUrl(Uri $uri): self
    {
        $this->url = $uri;

        return $this;
    }

    public function unsetUrl(): self
    {
        $this->url = null;

        return $this;
    }

    public function hasOccurrence(): bool
    {
        return $this->occurrence !== null;
    }

    public function getOccurrence(): Occurrence
    {
        assert($this->occurrence !== null);

        return $this->occurrence;
    }

    public function setOccurrence(Occurrence $occurrence): self
    {
        $this->occurrence = $occurrence;

        return $this;
    }

    public function getLocation(): Location
    {
        assert($this->location !== null);

        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function hasLocation(): bool
    {
        return $this->location !== null;
    }

    public function getOrganizer(): Organizer
    {
        assert($this->organizer !== null);

        return $this->organizer;
    }

    public function setOrganizer(?Organizer $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function hasOrganizer(): bool
    {
        return $this->organizer !== null;
    }

    /**
     * @return Alarm[]
     */
    public function getAlarms(): array
    {
        return $this->alarms;
    }

    public function addAlarm(Alarm $alarm): self
    {
        $this->alarms[] = $alarm;

        return $this;
    }

    public function addAttachment(Attachment $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function getLastModified(): Timestamp
    {
        assert($this->lastModified !== null);

        return $this->lastModified;
    }

    public function hasLastModified(): bool
    {
        return $this->lastModified !== null;
    }

    public function setLastModified(?Timestamp $lastModified): self
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function hasAttendee(): bool
    {
        return !empty($this->attendees);
    }

    public function addAttendee(Attendee $attendee): self
    {
        $this->attendees[] = $attendee;

        return $this;
    }

    /**
     * @param Attendee[] $attendees
     */
    public function setAttendees(array $attendees): self
    {
        $this->attendees = $attendees;

        return $this;
    }

    /**
     * @return Attendee[]
     */
    public function getAttendees(): array
    {
        return $this->attendees;
    }

    public function hasCategories(): bool
    {
        return !empty($this->categories);
    }

    public function addCategory(Category $category): self
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * @param Category[] $categories
     */
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getStatus(): EventStatus
    {
        assert($this->status !== null);

        return $this->status;
    }

    public function hasStatus(): bool
    {
        return $this->status !== null;
    }

    public function setStatus(EventStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function unsetStatus(): self
    {
        $this->status = null;

        return $this;
    }
}
