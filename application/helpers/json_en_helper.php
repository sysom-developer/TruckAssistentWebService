<?php

/**
 * 
 * 封装json_encode函数
 */
if ( ! function_exists('json_en'))
{
    function json_en($array) {
        $CI =& get_instance();

        if ($CI->data['n'] == 1) {
            echo '<pre>';
            print_r($array);
            echo '</pre>';
            exit;
        }

        if ($array['application']['head']['code'] == 'E000000000') {
            $array['application']['body'] = $array['body'];
            unset($array['body']);
        }

        $json_str = json_encode($array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $json_str = str_replace("\\\\\\", "\\", $json_str);

        return $json_str;
    }
}