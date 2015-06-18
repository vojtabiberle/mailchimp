<?php

namespace Mailchimp\Common;

class Utils
{
    public static function CamelCase($str, array $noStrip = [])
    {
        $str = strtolower($str);
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace(
            '/[^a-z0-9' . implode('', $noStrip) . ']+/i', ' ', $str
        );
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);

        return $str;
    }
}