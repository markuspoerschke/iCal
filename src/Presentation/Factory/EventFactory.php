<?php

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;
use Eluceo\iCal\Presentation\Factory\Property\TimestampPropertyFactory;

class EventFactory
{
    private TimestampPropertyFactory $timestampPropertyFactory;

    public function __construct(?TimestampPropertyFactory $timestampPropertyFactory = null)
    {
        $this->timestampPropertyFactory = $timestampPropertyFactory ?? new TimestampPropertyFactory();
    }

    public function createComponent(Event $event): Component
    {
        $properties = [
            Property::create('UID', StringValue::fromString($event->getUniqueIdentifier())),
            $this->timestampPropertyFactory->fromTimestamp('DTSTAMP', $event->getTouchedAt()),
        ];

        if ($event->hasSummary()) {
            $properties[] = Property::create('SUMMARY', StringValue::fromString($event->getSummary()));
        }

        return Component::create('VEVENT', $properties);
    }
}
