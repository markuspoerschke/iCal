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

final class MethodType
{
    private static ?self $publish = null;
    private static ?self $cancel = null;

    private string $method;

    public function __construct(string $method)
    {
        assert(!empty($method), 'Method cannot be empty');

        $this->method = $method;
    }

    public static function PUBLISH(): self
    {
        return self::$publish = self::$publish ?? new MethodType('PUBLISH');
    }

    public static function CANCELLED(): self
    {
        return self::$cancel = self::$cancel ?? new MethodType('CANCEL');
    }

    public function __toString()
    {
        return $this->method;
    }
}
