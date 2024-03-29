<?php

namespace Qin\Web3Php\account;
use Qin\Web3Php\ethKey\PrivateKey;

class Account
{
    public $privateKey;
    public $address;

    public function __construct(string $privateKey = '')
    {
        $this->privateKey = new PrivateKey($privateKey);
        $this->address = $this->privateKey->publicKey->address();
    }
}