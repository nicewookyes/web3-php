<?php
namespace Qin\Web3Php\eth_key;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Qin\Web3Php\eth_utils\Conversions;

class PrivateKey{
    private $key;
    public $publicKey;
    private const SIZE = 64;

    public function __construct($privateKey)
    {
        $generator = EccFactory::getSecgCurves()->generator256k1();
        if (empty ($privateKey)) {
            $this->key = $generator->createPrivateKey();
        } else {
            $privateKey = Conversions::removeZeroPrefix($privateKey);
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

    public function hex(){
        $derPrivateKeySerializer = new DerPrivateKeySerializer();
        return $derPrivateKeySerializer->serialize($this->key);
        return $this->key->getSecret();
    }
}