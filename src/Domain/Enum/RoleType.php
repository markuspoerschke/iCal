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

final class RoleType
{
    public const CHAIR = 'CHAIR';
    public const REQ_PARTICIPANT = 'REQ-PARTICIPANT';
    public const OPT_PARTICIPANT = 'OPT-PARTICIPANT';
    public const NON_PARTICIPANT = 'NON-PARTICIPANT';
}
