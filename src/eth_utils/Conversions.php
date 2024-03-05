<?php

namespace Qin\Web3Php\eth_utils;
class  Conversions
{
    public static function to_bytes($text)
    {
        $bytes = array();
        for ($i = 0; $i < strlen($text); $i++) {
            $bytes[] = ord($text[$i]);
        }
        return $bytes;
    }
}
