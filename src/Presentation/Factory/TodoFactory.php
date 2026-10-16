<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\Entity\Todo;
use Eluceo\iCal\Domain\Enum\TodoStatus;
use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\Category;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\PointInTime;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value\BinaryValue;
use Eluceo\iCal\Presentation\Component\Property\Value\DateTimeValue;
use Eluceo\iCal\Presentation\Component\Property\Value\DateValue;
use Eluceo\iCal\Presentation\Component\Property\Value\IntegerValue;
use Eluceo\iCal\Presentation\Component\Property\Value\ListValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\Component\Property\Value\UriValue;
use Generator;
use UnexpectedValueException;

/**
 * @SuppressWarnings("CouplingBetweenObjects")
 */
class TodoFactory
{
    private AlarmFactory $alarmFactory;
    private DateTimeFactory $dateTimeFactory;
    private AttendeeFactory $attendeeFactory;

    public function __construct(
        ?AlarmFactory $alarmFactory = null,
        ?DateTimeFactory $dateTimeFactory = null,
        ?AttendeeFactory $attendeeFactory = null,
    ) {
        $this->alarmFactory = $alarmFactory ?? new AlarmFactory();
        $this->dateTimeFactory = $dateTimeFactory ?? new DateTimeFactory();
        $this->attendeeFactory = $attendeeFactory ?? new AttendeeFactory();
    }

    /**
     * @param iterable<Todo> $todos
     *
     * @return Generator<Component>
     */
    final public function createComponents(iterable $todos): Generator
    {
        foreach ($todos as $todo) {
            yield $this->createComponent($todo);
        }
    }

    public function createComponent(Todo $todo): Component
    {
        return new Component(
            'VTODO',
            iterator_to_array($this->getProperties($todo), false),
            iterator_to_array($this->getComponents($todo), false)
        );
    }

    /**
     * @return Generator<Property>
     */
    protected function getProperties(Todo $todo): Generator
    {
        yield new Property('UID', new TextValue((string) $todo->getUniqueIdentifier()));
        yield new Property('DTSTAMP', new DateTimeValue($todo->getTouchedAt()));

        if ($todo->hasLastModified()) {
            yield new Property('LAST-MODIFIED', new DateTimeValue($todo->getLastModified()));
        }

        if ($todo->hasSummary()) {
            yield new Property('SUMMARY', new TextValue($todo->getSummary()));
        }

        if ($todo->hasDescription()) {
            yield new Property('DESCRIPTION', new TextValue($todo->getDescription()));
        }

        if ($todo->hasHtmlDescription()) {
            yield new Property('X-ALT-DESC', new TextValue($todo->getHtmlDescription()), [
                new Parameter('FMTTYPE', new TextValue('text/html')),
            ]);
        }

        if ($todo->hasUrl()) {
            yield new Property('URL', new TextValue($todo->getUrl()->getUri()));
        }

        if ($todo->hasStart()) {
            yield $this->createPointInTimeProperty('DTSTART', $todo->getStart());
        }

        if ($todo->hasDue()) {
            yield $this->createPointInTimeProperty('DUE', $todo->getDue());
        }

        if ($todo->hasCompletedAt()) {
            yield new Property('COMPLETED', new DateTimeValue($todo->getCompletedAt()));
        }

        if ($todo->hasStatus()) {
            yield new Property('STATUS', $this->getTodoStatusTextValue($todo->getStatus()));
        }

        if ($todo->hasPercentComplete()) {
            yield new Property('PERCENT-COMPLETE', new IntegerValue($todo->getPercentComplete()));
        }

        if ($todo->hasOrganizer()) {
            yield $this->getOrganizerProperty($todo->getOrganizer());
        }

        if ($todo->hasAttendee()) {
            foreach ($todo->getAttendees() as $attendee) {
                yield $this->attendeeFactory->createProperty($attendee);
            }
        }

        if ($todo->hasCategories()) {
            yield $this->getCategoryProperty($todo->getCategories());
        }

        foreach ($todo->getAttachments() as $attachment) {
            yield from $this->getAttachmentProperties($attachment);
        }
    }

    /**
     * @return Generator<Component>
     */
    protected function getComponents(Todo $todo): Generator
    {
        yield from array_map(
            fn (Alarm $alarm) => $this->alarmFactory->createComponent($alarm),
            $todo->getAlarms()
        );
    }

    private function createPointInTimeProperty(string $name, PointInTime $pointInTime): Property
    {
        if ($pointInTime instanceof Date) {
            return new Property(
                $name,
                new DateValue($pointInTime),
                [
                    new Parameter('VALUE', new TextValue('DATE')),
                ]
            );
        }

        return $this->dateTimeFactory->createProperty($name, $pointInTime);
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

    private function getOrganizerProperty(Organizer $organizer): Property
    {
        $parameters = [];

        if ($organizer->hasDisplayName()) {
            $parameters[] = new Parameter('CN', new TextValue($organizer->getDisplayName()));
        }

        if ($organizer->hasDirectoryEntry()) {
            $parameters[] = new Parameter('DIR', new UriValue($organizer->getDirectoryEntry()));
        }

        if ($organizer->isSentInBehalfOf()) {
            $parameters[] = new Parameter('SENT-BY', new UriValue($organizer->getSentBy()->toUri()));
        }

        return new Property('ORGANIZER', new UriValue($organizer->getEmailAddress()->toUri()), $parameters);
    }

    /**
     * @param array<Category> $categories
     */
    private function getCategoryProperty(array $categories): Property
    {
        $categoryValues = [];
        foreach ($categories as $category) {
            $categoryValues[] = new TextValue((string) $category);
        }

        return new Property('CATEGORIES', new ListValue($categoryValues));
    }

    private function getTodoStatusTextValue(TodoStatus $status): TextValue
    {
        if ($status === TodoStatus::CANCELLED()) {
            return new TextValue('CANCELLED');
        }

        if ($status === TodoStatus::COMPLETED()) {
            return new TextValue('COMPLETED');
        }

        if ($status === TodoStatus::IN_PROCESS()) {
            return new TextValue('IN-PROCESS');
        }

        if ($status === TodoStatus::NEEDS_ACTION()) {
            return new TextValue('NEEDS-ACTION');
        }

        throw new UnexpectedValueException(sprintf('The enum %s resulted into an unknown status type value that is not yet implemented.', TodoStatus::class));
    }
}
