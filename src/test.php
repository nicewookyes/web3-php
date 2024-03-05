<?php



//require_once('eth_utils/Conversions.php');
//use Qin\Web3Php\eth_utils\Conversions;
//
//var_dump(Conversions::toBytes(random_bytes(32)));
//echo "\n";
//var_dump(Conversions::to_bytes("Hello"));

//var_dump(random_bytes(32));

require_once("vendor/autoload.php");
//require_once("eth_key/PrivateKey.php");
//require_once("eth_key/PublicKey.php");
use Qin\Web3Php\account\Account;

$account = new Account();
var_dump($account->privateKey->hex());
var_dump($account->privateKey->publicKey->hex());
