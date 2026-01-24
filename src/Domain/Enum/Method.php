<?php

namespace Eluceo\iCal\Domain\Enum;

final class Method
{
    private static ?self $request = null;
    private static ?self $publish = null;

    public static function REQUEST(): self
    {
        return self::$request ??= new self();
    }

    public static function PUBLISH(): self
    {
        return self::$publish ??= new self();
    }
}
