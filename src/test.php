<?php



require_once('eth_utils/Conversions.php');
use Qin\Web3Php\eth_utils\Conversions;

var_dump(Conversions::to_bytes(random_bytes(32)));
//echo "\n";
//var_dump(Conversions::to_bytes("Hello"));

//var_dump(random_bytes(32));
