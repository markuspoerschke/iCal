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

final class CalendarUserType
{
    public const INDIVIDUAL = 'INDIVIDUAL';
    public const GROUP = 'GROUP';
    public const RESOURCE = 'RESOURCE';
    public const ROOM = 'ROOM';
    public const UNKNOWN = 'UNKNOWN';
}
