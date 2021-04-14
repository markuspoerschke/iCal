<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Entity;

use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\Occurrence;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;

class Event
{
    private UniqueIdentifier $uniqueIdentifier;
    private Timestamp $touchedAt;
    private ?string $summary = null;
    private ?string $description = null;
    private ?Occurrence $occurrence = null;
    private ?Location $location = null;
    private ?Timestamp $lastModified = null;
    protected array $attributes = [];

    /**
     * @var array<Alarm>
     */
    private array $alarms = [];

    /**
     * @var array<Attachment>
     */
    private array $attachments = [];

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


    public function setLastModified(Timestamp $dateTime): self
    {
        $this->lastModified = $dateTime;
        return $this;
    }

    public function getLastModified(): ?Timestamp
    {
        return $this->lastModified;
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


    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value): void
    {
        $this->setAttribute($name, $value);
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }


    public function __unset(string $name): void
    {
        unset($this->attributes[$name]);
    }


    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setAttribute(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }
}
