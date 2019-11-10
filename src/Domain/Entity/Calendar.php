<?php

namespace Eluceo\iCal\Domain\Entity;

use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;

class Calendar
{
    private UniqueIdentifier $productIdentifier;

    /**
     * @var Event[]
     */
    private array $events = [];

    private function __construct(UniqueIdentifier $productIdentifier, array $events)
    {
        $this->productIdentifier = $productIdentifier;
        array_walk($events, [$this, 'addEvent']);
    }

    public static function create(?UniqueIdentifier $productIdentifier = null, array $events = []): self
    {
        return new static($productIdentifier ?? UniqueIdentifier::create(), $events);
    }

    public function getProductIdentifier(): UniqueIdentifier
    {
        return $this->productIdentifier;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    private function addEvent(Event $event): void
    {
        $this->events[] = $event;
    }
}
