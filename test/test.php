<?php
require_once("../vendor/autoload.php");
use Qin\Web3Php\account\Account;



$account = new Account();
var_dump($account->privateKey->hex());
var_dump($account->privateKey->publicKey->hex());
var_dump($account->address);