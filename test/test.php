<?php
require_once("../vendor/autoload.php");
use Qin\Web3Php\account\Account;



$account = new Account("80f5785770e616fcd186ebf0613cdd461d238952c0f57d85cec31e5e42700f11");
var_dump($account->privateKey->hex());
var_dump($account->privateKey->publicKey->hex());
var_dump($account->address);