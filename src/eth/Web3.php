<?php
namespace Qin\Web3Php\eth;

use Qin\Web3Php\ethUtils\Utils;

class Web3{
    public $eth;
    public $utils;

    public function __construct($provider)
    {
        $this->eth = new Eth($provider);
        $this->utils = new Utils();
    }
}