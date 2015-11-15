<?php

namespace comm;

class Byte{

    /**
     * 把字符串转为16进制
     * ord, 返回首个字符的ASCII值
     * dechex,把10进制转为16进制
     */
    public static function String2Hex($string)
    {
        $hex_string = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex = dechex(ord($string[$i]));
            if (strlen($hex) == 1) {
                $hex = '0'.$hex;
            }
            $hex_string = $hex_string . $hex;
        }
        return $hex_string;
    }


    /**
     * 把16进制转为字符串
     * chr，把ASCII值转换为字符
     * hexdec，把16进制转为10进制
     */
    public static function Hex2String($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }


}