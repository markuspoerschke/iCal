<?php

namespace Eluceo\iCal\Util;

class PropertyValueUtil
{
    public static function escapeValue($value)
    {
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace('"', '\\"', $value);
        $value = str_replace(',', '\\,', $value);
        $value = str_replace(';', '\\;', $value);
        $value = str_replace("\n", '\\n', $value);

        return $value;
    }
}
