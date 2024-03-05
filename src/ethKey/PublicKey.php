<?php
namespace Qin\Web3Php\ethKey;
use kornrunner\Keccak;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;

class PublicKey{
    private $pub;

    public function __construct(\Mdanter\Ecc\Crypto\Key\PublicKey $pub)
    {
        $this->pub = $pub;
    }

    public function hex(){
        $publicKeySerializer = new DerPublicKeySerializer(EccFactory::getAdapter());
        return substr($publicKeySerializer->getUncompressedKey($this->pub), 2);
    }

    public function address(){
        $hash = Keccak::hash(hex2bin($this->hex()), 256);
        return substr($hash, -40);
    }
}