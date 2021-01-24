<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\Entity\TimeZone;
use Eluceo\iCal\Domain\Enum\TimeZoneTransitionType;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\TimeZoneTransition;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property\Value\DateTimeValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\Component\Property\Value\UtcOffsetValue;
use Generator;

class TimeZoneFactory
{
    /**
     * @param iterable<TimeZone> $timeZones
     *
     * @return Generator<Component>
     */
    public function createComponents(iterable $timeZones): Generator
    {
        foreach ($timeZones as $timeZone) {
            yield $this->createComponent($timeZone);
        }
    }

    protected function createComponent(TimeZone $timeZone): Component
    {
        return new Component(
            'VTIMEZONE',
            [
                new Component\Property('TZID', new TextValue($timeZone->getTimeZoneId())),
            ],
            array_map(
                fn (TimeZoneTransition $transition): Component => $this->createTransitionSubComponent($transition),
                $timeZone->getTransitions()
            )
        );
    }

    private function createTransitionSubComponent(TimeZoneTransition $transition): Component
    {
        return new Component(
            $transition->getType() === TimeZoneTransitionType::DAYLIGHT() ? 'DAYLIGHT' : 'STANDARD',
            [
                new Component\Property('DTSTART', new DateTimeValue(new DateTime($transition->getFromDateTime(), false))),
                new Component\Property('TZNAME', new TextValue($transition->getTimeZoneName())),
                new Component\Property('TZOFFSETTO', UtcOffsetValue::fromSeconds($transition->getOffsetTo())),
                new Component\Property('TZOFFSETFROM', UtcOffsetValue::fromSeconds($transition->getOffsetFrom())),
            ]
        );
    }
}
