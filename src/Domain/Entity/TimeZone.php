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

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone as PhpDateTimeZone;
use Eluceo\iCal\Domain\Enum\TimeZoneTransitionType;
use Eluceo\iCal\Domain\ValueObject\TimeZoneTransition;

class TimeZone
{
    private string $timeZoneId;

    /**
     * @var array<array-key, TimeZoneTransition>
     */
    private array $transitions = [];

    public function __construct(string $timeZoneId)
    {
        $this->timeZoneId = $timeZoneId;
    }

    public static function createFromPhpDateTimeZone(
        PhpDateTimeZone $phpDateTimeZone,
        ?DateTimeInterface $beginDateTime = null,
        ?DateTimeInterface $endDateTime = null
    ): self {
        if ($beginDateTime === null || $endDateTime === null) {
            trigger_deprecation('eluceo/ical', '2.1.0', 'Relying on the default values for begin and end date when calling TimeZone::createFromPhpDateTimeZone() is deprecated. Please provide a begin and an end date.');
        }

        $transitions = $phpDateTimeZone->getTransitions(
            $beginDateTime ? $beginDateTime->getTimestamp() : (new DateTimeImmutable('0000-01-01 12:00:00'))->getTimestamp(),
            $endDateTime ? $endDateTime->getTimestamp() : PHP_INT_MAX
        );
        $timeZone = new self($phpDateTimeZone->getName());

        foreach ($transitions as $transitionArray) {
            $fromDateTime = DateTimeImmutable::createFromFormat(
                DateTimeImmutable::ISO8601,
                $transitionArray['time']
            );
            assert($fromDateTime instanceof DateTimeImmutable, $transitionArray['time']);
            $localFromDateTime = $fromDateTime->setTimezone($phpDateTimeZone);

            $timeZone->addTransition(new TimeZoneTransition(
                $transitionArray['isdst'] ? TimeZoneTransitionType::DAYLIGHT() : TimeZoneTransitionType::STANDARD(),
                $localFromDateTime,
                $phpDateTimeZone->getOffset($fromDateTime->sub(new DateInterval('PT1S'))),
                $transitionArray['offset'],
                $transitionArray['abbr']
            ));
        }

        return $timeZone;
    }

    public function getTimeZoneId(): string
    {
        return $this->timeZoneId;
    }

    public function addTransition(TimeZoneTransition $transition): self
    {
        $this->transitions[] = $transition;

        return $this;
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    /**
     * @param array<array-key, TimeZoneTransition> $transitions
     */
    public function setTransitions(array $transitions): self
    {
        $this->transitions = $transitions;

        return $this;
    }
}
