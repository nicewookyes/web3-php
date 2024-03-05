<?php
namespace Test;
use Qin\Web3Php\eth_utils\Conversions;

class Test{
    public function test(){
        echo Conversions::to_bytes("你好啊");
        echo "\n";
        echo Conversions::to_bytes("Hello");
    }
}

$t = new Test();
$t->test();