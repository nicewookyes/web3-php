<?php

namespace Qin\Web3Php\eth_key;

class Validations
{
    public static function isHexString(string $text)
    {
        if (!is_string($text)) {
            return false;
        }
        return (preg_match('/^{0x}?[a-fA-F0-9]+$/', $text) >= 1);
    }

    public static function hexLen(string $text, int $len)
    {
        return strlen($text) == $len;
    }
}