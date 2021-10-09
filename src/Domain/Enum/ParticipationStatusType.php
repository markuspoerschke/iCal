<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Enum;

final class ParticipationStatusType
{
    // Generic (for event, todo and journal)
    public const NEEDS_ACTION = 'NEEDS-ACTION';
    public const ACCEPTED = 'ACCEPTED';
    public const DECLINED = 'DECLINED';

    // For event
    public const TENTATIVE = 'TENTATIVE';
    public const DELEGATED = 'DELEGATED';

    // For Todo
    public const COMPLETED = 'COMPLETED';
    public const IN_PROCESS = 'IN-PROCESS';
}
