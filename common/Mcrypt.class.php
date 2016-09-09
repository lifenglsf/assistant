<?php
namespace common;
/**
 * @filename Mcrypt.class.php
 * @encoding UTF-8
 * @author KangYun@winsan.cn
 * @copyright WinSan.cn
 * @datetime 2015-7-27 15:05:22
 * @version 1.0
 * @Description
 * Example:
 * encrypt:
 * $encrypt_result = Mcrypt::encrypt("XXXX|YYYYY|ZZZZZZ", "9527");
 * decrypt:
 * $decrypt_result = Mcrypt::decrypt("XXYYZZZDSSdSD", "9527");
 * 
 */
class Mcrypt {

    public static function encrypt($value, $encrypt_key) {
        $td = mcrypt_module_open('tripledes', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        $key = substr($encrypt_key, 0, mcrypt_enc_get_key_size($td));
        mcrypt_generic_init($td, $key, $iv);
        $ret = base64_encode(mcrypt_generic($td, $value));
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $ret;
    }

    public static function dencrypt($value, $encrypt_key) {
        $td = mcrypt_module_open('tripledes', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        $key = substr($encrypt_key, 0, mcrypt_enc_get_key_size($td));
       // $key = substr($encrypt_key, 0, mcrypt_enc_get_key_size($td));
        mcrypt_generic_init($td, $key, $iv);
        $ret = trim(mdecrypt_generic($td, base64_decode($value)));
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $ret;
    }

}
