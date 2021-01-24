<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject\Alarm;

use DateInterval;

final class RelativeTrigger extends Trigger
{
    /**
     * The trigger is either related to the start or end of an event.
     *
     * If the value is true, then the trigger is related to the start,
     * which is the default value.
     *
     * If the value is false, then the trigger is related to the end.
     */
    private bool $relatedToStart = true;

    private DateInterval $duration;

    public function __construct(DateInterval $duration)
    {
        $this->duration = $duration;
    }

    public function isRelatedToStart(): bool
    {
        return $this->relatedToStart;
    }

    public function isRelatedToEnd(): bool
    {
        return !$this->relatedToStart;
    }

    public function getDuration(): DateInterval
    {
        return $this->duration;
    }

    public function withRelationToEnd(): self
    {
        $new = clone $this;
        $new->relatedToStart = false;

        return $new;
    }

    public function withRelationToStart(): self
    {
        $new = clone $this;
        $new->relatedToStart = true;

        return $new;
    }
}
