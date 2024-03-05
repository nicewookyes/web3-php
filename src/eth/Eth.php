<?php
namespace Qin\Web3Php\eth;

use Qin\Web3Php\providers\HttpProvider;

class  Eth
{
    protected $rm;

    public function __construct($provider)
    {
        $this->rm = new HttpProvider($provider);
    }

    public function gasPrice()
    {
        return $this->rm->eth_gasPrice();
    }


    /**  Get the highest block number
     * @return string  like '1231231'
     */
    public function blockNumber()
    {
        $heightHex = $this->rm->eth_blockNumber();
        return base_convert($heightHex, 16, 10);
    }

    public function getBalance(string $address)
    {
        $balanceHex = $this->rm->eth_getBalance($address, "latest");
        return base_convert($balanceHex, 16, 10);
    }

    /**
     * @param string $address
     * @param string $tag ["pending","latest","earliest"]
     * @return mixed
     */
    public function getTransactionCount(string $address, string $tag = "pending")
    {
        return $this->rm->eth_getTransactionCount($address, $tag);
    }


    /**
     * @param string $hash The transaction hash like 0xba0d559d631cb3f00995463bc5812d657d8148dee9cd7b052c6438c703a91e3d
     * @return mixed
     */
    public function getBlockByHash(string $hash)
    {
        return $this->rm->eth_getBlockByHash($hash, true);
    }

    /**
     * @param int $number  Block number like 121231
     * @return mixed
     */
    public function getBlockByNumber(int $number)
    {
        $number = "0x" . base_convert($number, 10, 16);
        return $this->rm->eth_getBlockByNumber($number, true);
    }

    /**
     * @param string $hash The transaction hash like 0xba0d559d631cb3f00995463bc5812d657d8148dee9cd7b052c6438c703a91e3d
     * @return mixed
     */
    public function getTransactionByHash(string $hash)
    {
        return $this->rm->eth_getTransactionByHash($hash);
    }

    /**
     * @param string $hash The transaction hash like 0xba0d559d631cb3f00995463bc5812d657d8148dee9cd7b052c6438c703a91e3d
     * @return mixed
     */
    public function getTransactionReceipt(string $hash)
    {
        return $this->rm->eth_getTransactionReceipt($hash);
    }


    /**
     * @param string $from
     * @param string $to
     * @param int $value
     * @param string $data
     * @return string a hex string like "0x5208"
     */
    public function estimateGas($transaction): string
    {
        return $this->rm->eth_estimateGas($transaction);
    }


    /**
     * @param string $signTransaction  Signed transaction data
     * @return mixed
     */
    public function sendRawTransaction(string $signTransaction){
        return $this->rm->eth_sendRawTransaction($signTransaction);
    }
}