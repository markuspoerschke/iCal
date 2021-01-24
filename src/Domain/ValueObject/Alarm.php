<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

use DateInterval;
use Eluceo\iCal\Domain\ValueObject\Alarm\Action;
use Eluceo\iCal\Domain\ValueObject\Alarm\Trigger;

class Alarm
{
    private Action $action;
    private Trigger $trigger;

    private int $repeatCount = 0;
    private ?DateInterval $repeatInterval = null;

    public function __construct(Action $action, Trigger $trigger)
    {
        $this->action = $action;
        $this->trigger = $trigger;
    }

    public function getAction(): Action
    {
        return $this->action;
    }

    public function getTrigger(): Trigger
    {
        return $this->trigger;
    }

    public function isRepeated(): bool
    {
        return $this->repeatCount > 0;
    }

    public function withRepeat(int $repeatCount, DateInterval $repeatInterval): self
    {
        $this->repeatCount = $repeatCount;
        $this->repeatInterval = $repeatInterval;

        return $this;
    }

    public function withoutRepeat(): self
    {
        $this->repeatCount = 0;
        $this->repeatInterval = null;

        return $this;
    }

    public function getRepeatCount(): int
    {
        return $this->repeatCount;
    }

    public function getRepeatInterval(): DateInterval
    {
        assert($this->repeatInterval !== null);

        return $this->repeatInterval;
    }
}
