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

        $new = clone $this;
        $new->touchedAt = $dateTime;

        return $new;
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

    public function withSummary(string $summary): self
    {
        $new = clone $this;
        $new->summary = $summary;

        return $new;
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

    public function withDescription(string $description): self
    {
        $new = clone $this;
        $new->description = $description;

        return $new;
    }

    public function withoutDescription(): self
    {
        $new = clone $this;
        $new->description = null;

        return $new;
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

    public function withOccurrence(Occurrence $occurrence): self
    {
        $new = clone $this;
        $new->occurrence = $occurrence;

        return $new;
    }
}
