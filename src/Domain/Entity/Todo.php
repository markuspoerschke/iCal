<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Entity;

use Eluceo\iCal\Domain\Enum\TodoStatus;
use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\Category;
use Eluceo\iCal\Domain\ValueObject\PointInTime;
use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;
use Eluceo\iCal\Domain\ValueObject\Uri;
use InvalidArgumentException;

class Todo
{
    private UniqueIdentifier $uniqueIdentifier;
    private Timestamp $touchedAt;
    private ?string $summary = null;
    private ?string $description = null;
    private ?string $htmlDescription = null;
    private ?Uri $url = null;
    private ?PointInTime $start = null;
    private ?PointInTime $due = null;
    private ?Timestamp $completedAt = null;
    private ?Timestamp $lastModified = null;
    private ?TodoStatus $status = null;
    private ?int $percentComplete = null;
    private ?Organizer $organizer = null;

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

    public function __construct(?UniqueIdentifier $uniqueIdentifier = null)
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

    public function touch(?Timestamp $dateTime = null): self
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

    public function getHtmlDescription(): string
    {
        assert($this->htmlDescription !== null);

        return $this->htmlDescription;
    }

    public function hasHtmlDescription(): bool
    {
        return $this->htmlDescription !== null;
    }

    public function setHtmlDescription(string $htmlDescription): self
    {
        $this->htmlDescription = $htmlDescription;

        return $this;
    }

    public function unsetHtmlDescription(): self
    {
        $this->htmlDescription = null;

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

    public function hasStart(): bool
    {
        return $this->start !== null;
    }

    public function getStart(): PointInTime
    {
        assert($this->start !== null);

        return $this->start;
    }

    public function setStart(PointInTime $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function unsetStart(): self
    {
        $this->start = null;

        return $this;
    }

    public function hasDue(): bool
    {
        return $this->due !== null;
    }

    public function getDue(): PointInTime
    {
        assert($this->due !== null);

        return $this->due;
    }

    public function setDue(PointInTime $due): self
    {
        $this->due = $due;

        return $this;
    }

    public function unsetDue(): self
    {
        $this->due = null;

        return $this;
    }

    public function hasCompletedAt(): bool
    {
        return $this->completedAt !== null;
    }

    public function getCompletedAt(): Timestamp
    {
        assert($this->completedAt !== null);

        return $this->completedAt;
    }

    public function setCompletedAt(?Timestamp $completedAt): self
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function hasLastModified(): bool
    {
        return $this->lastModified !== null;
    }

    public function getLastModified(): Timestamp
    {
        assert($this->lastModified !== null);

        return $this->lastModified;
    }

    public function setLastModified(?Timestamp $lastModified): self
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function hasStatus(): bool
    {
        return $this->status !== null;
    }

    public function getStatus(): TodoStatus
    {
        assert($this->status !== null);

        return $this->status;
    }

    public function setStatus(TodoStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function unsetStatus(): self
    {
        $this->status = null;

        return $this;
    }

    public function hasPercentComplete(): bool
    {
        return $this->percentComplete !== null;
    }

    public function getPercentComplete(): int
    {
        assert($this->percentComplete !== null);

        return $this->percentComplete;
    }

    public function setPercentComplete(int $percentComplete): self
    {
        if ($percentComplete < 0 || $percentComplete > 100) {
            throw new InvalidArgumentException('$percentComplete must be between 0 and 100.');
        }

        $this->percentComplete = $percentComplete;

        return $this;
    }

    public function unsetPercentComplete(): self
    {
        $this->percentComplete = null;

        return $this;
    }

    public function hasOrganizer(): bool
    {
        return $this->organizer !== null;
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
}
