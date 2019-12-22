<?php
/**
 * Created by PhpStorm.
 * User: prajapatisajan
 * Date: 2018/07/19
 * Time: 10:52
 */

namespace App\Library;


class OpenSslCryptor
{
    /* @var string 暗号化方式 */
    private $crypt_method;

    /* @var string 暗号化キー */
    public $crypt_key;

    /* @var object 初期化ベクトル */
    private $initial_vector;

    /**
     * コンストラクタ
     *
     * @param string $crypt_method 暗号化方式 (openssl_get_cipher_methods()を参照)
     */
    public function __construct($crypt_method) {
        $this->crypt_method = $crypt_method;
        $this->crypt_key = config('constKey.PASSWORD_CRYPT_KEY');
        $this->initial_vector = config('constKey.INITIAL_VECTOR');
    }

    /**
     * 初期化ベクトルを設定
     *
     * @param string $initial_vector 初期化ベクトル (bin2hex()したもの)
     */
    public function setInitialVector($initial_vector) {
        $this->initial_vector = hex2bin($initial_vector);
    }

    /**
     * 初期化ベクトルを取得
     *
     * 初期化ベクトルは内部ではバイナリで扱うが、DB保存など外部での取り回しを意識してbin2hex()で16進数表記したものを返す
     * 外部から初期化ベクトルが与えられていない場合、ここでランダムな初期化ベクトルを生成して返す
     *
     * @return string 初期化ベクトル (hex2bin()したもの)
     */
    public function getInitialVector() {
        if (is_null($this->initial_vector)) {
            $this->initial_vector = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->crypt_method));
        }
        return bin2hex($this->initial_vector);
    }

    /**
     * 暗号化処理
     *
     * 暗号化したデータはDB保存など外部での取り回しを意識してbin2hex()で16進数表記したものを返す
     *
     * @param string $plain_text 暗号化したい文字列
     * @return string 暗号化されたデータ(bin2hex()済み)
     */
    public function encrypt($plain_text) {
        return bin2hex(
            openssl_encrypt(
                $this->pkcs5_padding($plain_text),
                $this->crypt_method,
                $this->crypt_key,
                OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                hex2bin($this->getInitialVector())
            )
        );
    }

    /**
     * 復号化処理
     *
     * @param string $encrypted_text 復号化したいデータ (16進数表記されたもの)
     * @return string 復号化された文字列
     */
    public function decrypt($encrypted_text) {
        return $this->pkcs5_suppress(
            openssl_decrypt(
                hex2bin($encrypted_text),
                $this->crypt_method,
                $this->crypt_key,
                OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                hex2bin($this->getInitialVector())
            )
        );
    }

    /**
     * パディング処理
     *
     * 暗号化方式で指定されているブロックサイズに合わせて文字列を埋める
     *
     * @param string $text 対象文字列
     * @return string パディング済みの文字列
     */
    private function pkcs5_padding($text) {
        $block_size = $this->openssl_cipher_block_length($this->crypt_method);
        $pad = $block_size - (strlen($text) % $block_size);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * サプレス処理
     *
     * 暗号化の際にブロックサイズ調整で埋められた文字を取り除く
     *
     * @param string $text 対象文字列
     * @return string ブロックサイズ調整文字を取り除いた文字列
     */
    private function pkcs5_suppress($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, strpos($text, chr($pad)));
    }

    /**
     * 暗号化方式が指定するブロック長を算出
     *
     * @param string $cipher 暗号化方式
     * @return int 暗号化方式が指定しているブロック長
     */
    function openssl_cipher_block_length($cipher) {
        $ivSize = @openssl_cipher_iv_length($cipher);

        // サポートしていない暗号化方式だった
        if ($ivSize === false) {
            return false;
        }

        $iv = str_repeat("a", $ivSize);

        // 1バイトから1024バイトまで順に暗号化可能なブロック長を試していく
        for ($size = 1; $size < 1024; $size++) {
            $output = openssl_encrypt(
                str_repeat("a", $size),
                $cipher,
                "a",
                OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                $iv
            );

            if ($output !== false) {
                return $size;
            }
        }

        return false;
    }
}