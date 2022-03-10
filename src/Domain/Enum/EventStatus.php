<?php

namespace Eluceo\iCal\Domain\Enum;

final class EventStatus
{
    private static self $cancelled;
    private static self $confirmed;
    private static self $tentative;

    public static function CANCELLED(): self
    {
        return self::$cancelled ??= new self();
    }

    public static function CONFIRMED(): self
    {
        return self::$confirmed ??= new self();
    }

    public static function TENTATIVE(): self
    {
        return self::$tentative ??= new self();
    }
}
