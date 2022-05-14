<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * @param mixed $str | #array
     *
     * @return $str | $array
     */
    public static function stripNonAscii($value) 
    {
        if (is_array($value) || is_string($value)) {
            $clean = preg_replace('/[^\x00-\x7F]+/', '', $value); // drop anything but ASCII
            return $clean;
        }
        return null;
    }

    public static function dateFormat($date)
    {
        //
    }
}