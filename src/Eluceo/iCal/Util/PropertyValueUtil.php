<?php

namespace Eluceo\iCal\Util;

class PropertyValueUtil
{
    public static function escapeValue($value)
    {
        $value = self::escapeValueAllowNewLine($value);
        $value = str_replace("\n", '\\n', $value);

        return $value;
    }

    public static function escapeValueAllowNewLine($value)
    {
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace('"', '\\"', $value);
        $value = str_replace(',', '\\,', $value);
        $value = str_replace(';', '\\;', $value);
        $value = str_replace(
            array(
                "\x00", "\x01", "\x02", "\x03", "\x04", "\x05", "\x06", "\x07",
                "\x08", "\x09", /* \n*/ "\x0B", "\x0C", "\x0D", "\x0E", "\x0F",
                "\x10", "\x11", "\x12", "\x13", "\x14", "\x15", "\x16", "\x17",
                "\x18", "\x19", "\x1A", "\x1B", "\x1C", "\x1D", "\x1E", "\x1F",
                "\x7F"), '', $value
        );

        // edrush: really not sure why all the code before but if we want to keep \n we can do the following
        $value = str_replace("\\\\n", "\\n", $value);

        return $value;
    }
}
