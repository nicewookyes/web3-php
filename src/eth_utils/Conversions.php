<?php

namespace Qin\Web3Php\eth_utils;
class  Conversions
{
    public static function to_bytes($text)
    {
        return mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }
}
