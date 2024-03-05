<?php

namespace Qin\Web3Php\ethKey;

use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Qin\Web3Php\ethUtils\Conversions;

class PrivateKey
{
    private $key;
    public $publicKey;
    private const SIZE = 64;

    public function __construct($privateKey)
    {
        $generator = EccFactory::getSecgCurves()->generator256k1();
        if (empty ($privateKey)) {
            $this->key = $generator->createPrivateKey();
        } else {
            if (substr($privateKey, 0, 2) == "0x") {
                $privateKey = substr($privateKey, 2);
            }
            if (!ctype_xdigit($privateKey)) {
                throw new InvalidArgumentException('Private key must be a hexadecimal number');
            }
            if (strlen($privateKey) != self::SIZE) {
                throw new InvalidArgumentException(sprintf('Private key should be exactly %d chars long', self::SIZE));
            }

            $key = gmp_init($privateKey, 16);
            $this->key = $generator->getPrivateKeyFrom($key);

        }
        $this->publicKey = new PublicKey($this->key->getPublicKey());
    }

    public function hex()
    {
        return str_pad(gmp_strval($this->key->getSecret(), 16), self::SIZE, '0', STR_PAD_LEFT);
    }
}