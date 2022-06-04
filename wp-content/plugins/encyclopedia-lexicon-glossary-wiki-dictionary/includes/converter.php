<?php

namespace WordPress\Plugin\Encyclopedia;

abstract class Converter
{
    public static function convertToString($value): string
    {
        if (is_array($value)) {
            $value = array_filter($value);
            $value = json_encode($value);
        } elseif (is_object($value)) {
            $value = json_encode($value);
        }

        $string = strval($value);
        return $string;
    }
}
