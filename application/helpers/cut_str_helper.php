<?php 

/**
 * php自带字符串截取函数
 */

if ( ! function_exists('cut_str'))
{
    function cut_str($s, $length, $start = 0, $seg = "", $encode = "utf-8")
    {
        $CI =& get_instance();
        
        if (strlen($s) <= $length) {
            return $s;
        }
        
        if (!(is_numeric($length) && $length > 0)) {
            exit("调用cut_str函数失败，参数错误");
        }
        
        $cut_s = mb_strcut($s, $start, $length, $encode).$seg;
        
        return $cut_s;
    }
}