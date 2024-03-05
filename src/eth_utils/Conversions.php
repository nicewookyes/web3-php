<?php

namespace Qin\Web3Php\eth_utils;
class  Conversions
{
    public static function toBytes(string $text)
    {
        $bytes = array();
        for ($i = 0; $i < strlen($text); $i++) {
            $bytes[] = ord($text[$i]);
        }
        return $bytes;
    }

    public static function addZeroPrefix(string $text){
        if(substr($text,0,2) != "0x"){
            return "0x".$text;
        }
        return $text;
    }

    public static function removeZeroPrefix(string $text){
        if(substr($text,0,2) == "0x"){
            return substr($text,2);
        }
        return $text;
    }
}
