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

use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Alarm\AbsoluteDateTimeTrigger;
use Eluceo\iCal\Domain\ValueObject\Alarm\Action;
use Eluceo\iCal\Domain\ValueObject\Alarm\AudioAction;
use Eluceo\iCal\Domain\ValueObject\Alarm\DisplayAction;
use Eluceo\iCal\Domain\ValueObject\Alarm\EmailAction;
use Eluceo\iCal\Domain\ValueObject\Alarm\RelativeTrigger;
use Eluceo\iCal\Domain\ValueObject\Alarm\Trigger;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value\DateTimeValue;
use Eluceo\iCal\Presentation\Component\Property\Value\DurationValue;
use Eluceo\iCal\Presentation\Component\Property\Value\IntegerValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Generator;

/**
 * @SuppressWarnings("CouplingBetweenObjects")
 */
class AlarmFactory
{
    public function createComponent(Alarm $alarm): Component
    {
        return new Component('VALARM', iterator_to_array($this->getProperties($alarm), false));
    }

    /**
     * @return Generator<Property>
     */
    private function getProperties(Alarm $alarm): Generator
    {
        yield from $this->getActionProperties($alarm->getAction());
        yield from $this->getTriggerProperties($alarm->getTrigger());
        yield from $this->getRepeatProperties($alarm);
    }

    /**
     * @return Generator<Property>
     */
    private function getRepeatProperties(Alarm $alarm): Generator
    {
        if (!$alarm->isRepeated()) {
            return;
        }

        yield new Property('REPEAT', new IntegerValue($alarm->getRepeatCount()));
        yield new Property('DURATION', new DurationValue($alarm->getRepeatInterval()));
    }

    /**
     * @return Generator<Property>
     */
    private function getTriggerProperties(Trigger $trigger): Generator
    {
        if ($trigger instanceof AbsoluteDateTimeTrigger) {
            yield new Property(
                'TRIGGER',
                new DateTimeValue($trigger->getDateTime()),
                [
                    new Parameter('VALUE', new TextValue('DATE-TIME')),
                ]
            );
        }

        if ($trigger instanceof RelativeTrigger) {
            yield new Property(
                'TRIGGER',
                new DurationValue($trigger->getDuration()),
                $trigger->isRelatedToEnd() ? [new Parameter('RELATED', new TextValue('END'))] : []
            );
        }
    }

    /**
     * @return Generator<Property>
     */
    private function getActionProperties(Action $action): Generator
    {
        if ($action instanceof AudioAction) {
            yield new Property('ACTION', new TextValue('AUDIO'));
        }

        if ($action instanceof EmailAction) {
            yield new Property('ACTION', new TextValue('EMAIL'));
            yield new Property('SUMMARY', new TextValue($action->getSummary()));
            yield new Property('DESCRIPTION', new TextValue($action->getDescription()));
        }

        if ($action instanceof DisplayAction) {
            yield new Property('ACTION', new TextValue('DISPLAY'));
            yield new Property('DESCRIPTION', new TextValue($action->getDescription()));
        }
    }
}
