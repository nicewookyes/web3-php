<?php
namespace Test;
use Qin\Web3Php\eth_utils\Conversions;

class Test{
    public function test(){
        echo Conversions::toBytes("你好啊");
        echo "\n";
        echo Conversions::toBytes("Hello");
    }
}

$t = new Test();
$t->test();