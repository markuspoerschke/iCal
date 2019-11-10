<?php

namespace Eluceo\iCal\Domain\Entity;

use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;

class Event
{
    private UniqueIdentifier $uniqueIdentifier;
    private Timestamp $touchedAt;
    private ?string $summary = null;

    private function __construct(UniqueIdentifier $uniqueIdentifier)
    {
        $this->uniqueIdentifier = $uniqueIdentifier;
        $this->touchedAt = DateTime::fromCurrentTime();
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
        $new = clone $this;
        $new->touchedAt = $dateTime;

        return $new;
    }

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
}
