<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: CryptoManager.php
 *
 *
 * Created: 1/20/20, 1:04 PM
 * Last modified: 1/20/20, 5:57 AM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\classes\security;
use InvalidArgumentException;

/**
 * Class CryptoManager
 * @package BlackHawk\classes\security
 */
class CryptoManager
{
    /**
     * Encrypts data using AES256-CBC
     *
     * @param string $encryptionKey Plaintext of key used to encrypt
     * @param mixed $data Data to encrypt (binary)
     * @param string $vS1 VirtualSalt X1*X4
     * @param string $vS2 VirtualSalt X2
     * @param string $vS3 VirtualSalt X1
     *
     * @return string Encryption result (bytes)
     */
    public static function AesEncrypt(string $encryptionKey, $data, string $vS1 = "AxBe21#F)1&834mbNC92~", string $vS2 = "ZehAn1-vMSA2n++", string $vS3 = "xNbl20??>2mg@") {
        $key = hash("sha256", hex2bin(implode(unpack("H*", $vS1.$encryptionKey))));
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("AES-256-CBC"));
        return hex2bin(implode(unpack("H*", $vS2))) . $iv . openssl_encrypt($data, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv) . hex2bin(implode(unpack("H*", $vS3)));
    }

    /**
     * Decrypts data using AES256-CBC
     *
     * @param string $encryptionKey Plaintext of key used to encrypt
     * @param mixed $data Data to decrypt
     * @param string $vS1 VirtualSalt X4*X1
     * @param int $vS2 VirtualSalt Z2
     * @param int $vS3 VirtualSalt Z1
     *
     * @return string Decryption result
     * @throws InvalidArgumentException  In the case decryption fails.
     */
    public static function AesDecrypt(string $encryptionKey, $data, string $vS1 = "AxBe21#F)1&834mbNC92~", int $vS2 = 15, int $vS3 = 13) {
        $key = hash("sha256", hex2bin(implode(unpack("H*", $vS1.$encryptionKey))));
        $iv = mb_substr($data, $vS2, $vS2 + openssl_cipher_iv_length("AES-256-CBC"), '8bit');
        $decData = mb_substr($data, $vS2, mb_strlen($data, '8bit') - $vS3, '8bit');
        $val = openssl_decrypt($decData, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);
        if ($val === FALSE) {
            throw new InvalidArgumentException("AES Decryption error.");
        }
        return $val;
    }

}