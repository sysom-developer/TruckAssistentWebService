<?php

/**
 * 
 * 清除HTML代码、空格、回车换
 */
if ( ! function_exists('delete_html'))
{
    function delete_html($str)
    {
        $str = trim($str);
        $str = strip_tags($str, "");
        $str = str_replace("\t", "", $str);
        $str = str_replace("\r\n", "", $str);
        $str = str_replace("\r", "", $str);
        $str = str_replace("\n", "", $str);
        $str = str_replace("　", " ", $str);
        $str = str_replace(" ", " ", $str);

        return trim($str);
    }
}