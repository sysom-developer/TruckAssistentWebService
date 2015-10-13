<?php 

/**
 * 解密
 */

if ( ! function_exists('secret_string'))
{
    function secret_string($string)
    {
        $CI =& get_instance();

        $key = $CI->config->config['encryption_key'];

        //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
        $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';

        $lockLen = strlen($lockstream);
        //获得字符串长度
        $txtLen = strlen($string);
        //截取随机密锁值
        $randomLock = $string[$txtLen - 1];
        //获得随机密码值的位置
        $lockCount = strpos($lockstream,$randomLock);
        //结合随机密锁值生成MD5后的密码
        $password = md5($key.$randomLock);
        //开始对字符串解密
        $txtStream = substr($string,0,$txtLen-1);
        $tmpStream = '';
        $i=0;$j=0;$k = 0;
        for($i=0; $i<strlen($txtStream); $i++){
        $k = ($k == strlen($password)) ? 0 : $k;
        $j = strpos($lockstream,$txtStream[$i]) - $lockCount - ord($password[$k]);
        while($j < 0){
        $j = $j + ($lockLen);
        }
        $tmpStream .= $lockstream[$j];
        $k++;
        }
        return base64_decode($tmpStream);
    }
}