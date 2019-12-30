<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Entity;

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

    private function __construct(UniqueIdentifier $uniqueIdentifier)
    {
        $this->uniqueIdentifier = $uniqueIdentifier;
        $this->touchedAt = Timestamp::fromCurrentTime();
    }

    public static function create(?UniqueIdentifier $uniqueIdentifier = null): self
    {
        return new static($uniqueIdentifier ?? UniqueIdentifier::create());
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
        if ($dateTime === null) {
            $dateTime = Timestamp::fromCurrentTime();
        }

        $this->touchedAt = $dateTime;

        return $this;
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function getSummary(): string
    {
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

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function getDescription(): string
    {
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

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function getOccurrence(): Occurrence
    {
        return $this->occurrence;
    }

    public function setOccurrence(Occurrence $occurrence): self
    {
        $this->occurrence = $occurrence;

        return $this;
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function getLocation(): Location
    {
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
}
