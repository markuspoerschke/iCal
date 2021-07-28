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

final class Status
{
    private static ?self $confirmed = null;
    private static ?self $cancelled = null;
    private static ?self $tentative = null;

    private string $status;

    public function __construct(string $status)
    {
        assert(!empty($status), 'Status cannot be empty');

        $this->status = $status;
    }

    public static function CONFIRMED(): self
    {
        return self::$confirmed = self::$confirmed ?? new Status('CONFIRMED');
    }

    public static function CANCELLED(): self
    {
        return self::$cancelled = self::$cancelled ?? new Status('CANCELLED');
    }

    public static function TENTATIVE(): self
    {
        return self::$tentative = self::$tentative ?? new Status('TENTATIVE');
    }

    public function __toString()
    {
        return $this->status;
    }
}
