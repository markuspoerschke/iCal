<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory;

use DateInterval;
use Eluceo\iCal\Domain\Collection\Events;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Domain\ValueObject\Occurrence;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value\BinaryValue;
use Eluceo\iCal\Presentation\Component\Property\Value\DateTimeValue;
use Eluceo\iCal\Presentation\Component\Property\Value\DateValue;
use Eluceo\iCal\Presentation\Component\Property\Value\GeoValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\Component\Property\Value\UriValue;
use Generator;

/**
 * @SuppressWarnings("CouplingBetweenObjects")
 */
class EventFactory
{
    private AlarmFactory $alarmFactory;

    public function __construct(?AlarmFactory $alarmFactory = null)
    {
        $this->alarmFactory = $alarmFactory ?? new AlarmFactory();
    }

    /**
     * @return Generator<Component>
     */
    final public function createComponents(Events $events): Generator
    {
        foreach ($events as $event) {
            yield $this->createComponent($event);
        }
    }

    public function createComponent(Event $event): Component
    {
        return new Component(
            'VEVENT',
            iterator_to_array($this->getProperties($event), false),
            iterator_to_array($this->getComponents($event), false)
        );
    }

    /**
     * @return Generator<Property>
     */
    protected function getProperties(Event $event): Generator
    {
        yield new Property('UID', new TextValue((string) $event->getUniqueIdentifier()));
        yield new Property('DTSTAMP', new DateTimeValue($event->getTouchedAt()));

        if ($event->hasSummary()) {
            yield new Property('SUMMARY', new TextValue($event->getSummary()));
        }

        if ($event->hasDescription()) {
            yield new Property('DESCRIPTION', new TextValue($event->getDescription()));
        }

        if ($event->hasOccurrence()) {
            yield from $this->getOccurrenceProperties($event->getOccurrence());
        }

        if ($event->hasLocation()) {
            yield from $this->getLocationProperties($event);
        }

        foreach ($event->getAttachments() as $attachment) {
            yield from $this->getAttachmentProperties($attachment);
        }
    }

    /**
     * @return Generator<Component>
     */
    protected function getComponents(Event $event): Generator
    {
        yield from array_map(
            fn (Alarm $alarm) => $this->alarmFactory->createComponent($alarm),
            $event->getAlarms()
        );
    }

    /**
     * @return Generator<Property>
     */
    private function getOccurrenceProperties(Occurrence $occurrence): Generator
    {
        if ($occurrence instanceof SingleDay) {
            yield new Property('DTSTART', new DateValue($occurrence->getDate()));
        }

        if ($occurrence instanceof MultiDay) {
            yield new Property('DTSTART', new DateValue($occurrence->getFirstDay()));
            yield new Property('DTEND', new DateValue($occurrence->getLastDay()->add(new DateInterval('P1D'))));
        }

        if ($occurrence instanceof TimeSpan) {
            yield new Property('DTSTART', new DateTimeValue($occurrence->getBegin()));
            yield new Property('DTEND', new DateTimeValue($occurrence->getEnd()));
        }
    }

    /**
     * @return Generator<Property>
     */
    private function getLocationProperties(Event $event): Generator
    {
        yield new Property('LOCATION', new TextValue((string) $event->getLocation()));

        if ($event->getLocation()->hasGeographicalPosition()) {
            yield new Property('GEO', new GeoValue($event->getLocation()->getGeographicPosition()));
        }
    }

    /**
     * @return Generator<Property>
     */
    private function getAttachmentProperties(Attachment $attachment): Generator
    {
        $parameters = [];

        if ($attachment->hasMimeType()) {
            $parameters[] = new Parameter('FMTTYPE', new TextValue($attachment->getMimeType()));
        }

        if ($attachment->hasUri()) {
            yield new Property(
                'ATTACH',
                new UriValue($attachment->getUri()),
                $parameters
            );
        }

        if ($attachment->hasBinaryContent()) {
            $parameters[] = new Parameter('ENCODING', new TextValue('BASE64'));
            $parameters[] = new Parameter('VALUE', new TextValue('BINARY'));

            yield new Property(
                'ATTACH',
                new BinaryValue($attachment->getBinaryContent()),
                $parameters
            );
        }
    }
}
