<?php

namespace Qin\Web3Php\ethUtils;

class Utils{
    const SHA3_NULL_HASH = 'c5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a470';

    const UNITS = [
        'noether' => '0',
        'wei' => '1',
        'kwei' => '1000',
        'Kwei' => '1000',
        'babbage' => '1000',
        'femtoether' => '1000',
        'mwei' => '1000000',
        'Mwei' => '1000000',
        'lovelace' => '1000000',
        'picoether' => '1000000',
        'gwei' => '1000000000',
        'Gwei' => '1000000000',
        'shannon' => '1000000000',
        'nanoether' => '1000000000',
        'nano' => '1000000000',
        'szabo' => '1000000000000',
        'microether' => '1000000000000',
        'micro' => '1000000000000',
        'finney' => '1000000000000000',
        'milliether' => '1000000000000000',
        'milli' => '1000000000000000',
        'ether' => '1000000000000000000',
        'kether' => '1000000000000000000000',
        'grand' => '1000000000000000000000',
        'mether' => '1000000000000000000000000',
        'gether' => '1000000000000000000000000000',
        'tether' => '1000000000000000000000000000000'
    ];

    public function fromWei($num, string $unit = 'ether'): string
    {
        $unitValue = self::UNITS[$unit];
        return $this->decodeValue($num, strlen($unitValue) - 1);
    }

    public function toWei($num, string $unit = 'ether'): string
    {
        $unitValue = self::UNITS[$unit];
        return $this->encodeValue($num, strlen($unitValue) - 1);
    }


    public function decodeValue($amount, int $_decimal): string
    {
        if (!is_string($amount)) {
            $amount = (string)$amount;
        }
        if ($amount == '0') {
            return '0';
        }
        $len = strlen($amount);

        if ($len == $_decimal) {
            $out = "0." . $amount;
        } elseif ($len > $_decimal) {
            $out = substr($amount, 0, $len - $_decimal) . "." . substr($amount, $len - $_decimal);
        } else {
            $out = "0." . str_repeat("0", $_decimal - $len) . $amount;
        }
        $end = strlen($out) - 1;
        while ($end > 0) {
            if (substr($out, $end, 1) != "0") {
                break;
            }
            $end--;
        }
        return substr($out, 0, $end + 1);
    }

    public function encodeValue($amount, int $_decimal): string
    {
        if (!is_string($amount)) {
            $amount = (string)$amount;
        }
        if ($amount == '0') {
            return '0';
        }

        if (strpos($amount, ".")) {
            $as = explode(".", $amount);
            if (strlen($as[1]) >= $_decimal) {
                $out = $as[0] . substr($as[1], 0, $_decimal);
            } else {
                $out = $as[0] . $as[1] . str_repeat("0", $_decimal - strlen($as[1]));
            }
        } else {
            $out = $amount . str_repeat("0", $_decimal);
        }
        return $out;
    }


    /**
     * hexToBin
     *
     * @param string
     * @return string
     */
    public function hexToBin($value): string
    {
        if (!is_string($value)) {
            throw new Exception('The value to hexToBin function must be string.');
        }
        if (self::isZeroPrefixed($value)) {
            $count = 1;
            $value = str_replace('0x', '', $value, $count);
        }
        return pack('H*', $value);
    }

    /**
     * isZeroPrefixed
     *
     * @param string
     * @return bool
     */
    public function isZeroPrefixed($value): bool
    {
        if (!is_string($value)) {
            throw new Exception('The value to isZeroPrefixed function must be string.');
        }
        return (strpos($value, '0x') === 0);
    }

    /**
     * stripZero
     *
     * @param string $value
     * @return string
     */
    public function stripZero($value): string
    {
        if (self::isZeroPrefixed($value)) {
            $count = 1;
            return str_replace('0x', '', $value, $count);
        }
        return $value;
    }

    /**
     * isNegative
     *
     * @param string
     * @return bool
     */
    public function isNegative($value): bool
    {
        if (!is_string($value)) {
            throw new Exception('The value to isNegative function must be string.');
        }
        return (strpos($value, '-') === 0);
    }

    /**
     * isAddress
     *
     * @param string $value
     * @return bool
     */
    public function isAddress($value): bool
    {
        if (!is_string($value)) {
            throw new Exception('The value to isAddress function must be string.');
        }
        if (preg_match('/^(0x|0X)?[a-f0-9A-F]{40}$/', $value) !== 1) {
            return false;
        } elseif (preg_match('/^(0x|0X)?[a-f0-9]{40}$/', $value) === 1 || preg_match('/^(0x|0X)?[A-F0-9]{40}$/', $value) === 1) {
            return true;
        }
        return self::isAddressChecksum($value);
    }

    /**
     * isAddressChecksum
     *
     * @param string $value
     * @return bool
     */
    public function isAddressChecksum($value): bool
    {
        if (!is_string($value)) {
            throw new Exception('The value to isAddressChecksum function must be string.');
        }
        $value = self::stripZero($value);
        $hash = self::stripZero(self::sha3(mb_strtolower($value)));

        for ($i = 0; $i < 40; $i++) {
            if (
                (intval($hash[$i], 16) > 7 && mb_strtoupper($value[$i]) !== $value[$i]) ||
                (intval($hash[$i], 16) <= 7 && mb_strtolower($value[$i]) !== $value[$i])
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * toChecksumAddress
     *
     * @param string $value
     * @return string
     */
    public function toChecksumAddress($value): string
    {
        if (!is_string($value)) {
            throw new Exception('The value to toChecksumAddress function must be string.');
        }
        $value = self::stripZero(strtolower($value));
        $hash = self::stripZero(self::sha3($value));
        $ret = '0x';

        for ($i = 0; $i < 40; $i++) {
            if (intval($hash[$i], 16) >= 8) {
                $ret .= strtoupper($value[$i]);
            } else {
                $ret .= $value[$i];
            }
        }
        return $ret;
    }

    /**
     * isHex
     *
     * @param string $value
     * @return bool
     */
    public function isHex($value): bool
    {
        return (is_string($value) && preg_match('/^(0x)?[a-f0-9]*$/', $value) === 1);
    }

    /**
     * sha3
     * keccak256
     *
     * @param string $value
     * @return string
     */
    public function sha3($value): ?string
    {
        if (!is_string($value)) {
            throw new Exception('The value to sha3 function must be string.');
        }
        if (strpos($value, '0x') === 0) {
            $value = self::hexToBin($value);
        }
        $hash = Keccak::hash($value, 256);

        if ($hash === self::SHA3_NULL_HASH) {
            return null;
        }
        return '0x' . $hash;
    }
}