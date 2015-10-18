<?php

/**
 * 递归过滤非法词
 */
if (!function_exists('words_filter')) {

    /**
     * @param mixed $data
     * @param string $log_type
     * @return mixed
     */
    function words_filter($data, $log_type = 'default') {
        $CI = & get_instance();
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    $data[$key] = words_filter($val);
                } else {
                    $data[$key] = filter_str($val);
                }
            }
        }
        return $data;
    }
}


/**
 * 过滤
 */
if (!function_exists('filter_str')) {
    /**
     * @param string $str
     * @param string $to
     * @return string
     */
    function filter_str($str, $to = '*') {
        $CI = & get_instance();

        $arrFilter = get_words_filter();
        //print_r($arrFilter);
        if (is_array($arrFilter) && count($arrFilter) > 0) {
            for ($i = 0; $i < count($arrFilter); $i++) {
                $str = preg_replace("/" . $arrFilter[$i] . "/im", $to, $str);
//                $str = strtr($str, $arrFilter[$i], $to);
            }
        }
        return $str;
    }

}

/**
 * 获取过滤词库
 */
if (!function_exists('get_words_filter')) {

    /**
     * @param string $log_type
     * @return mixed
     */
    function get_words_filter($log_type = 'default') {
        $CI = & get_instance();

        $words_filter = $CI->config->item('words_filter');

        return $words_filter[$log_type];
    }

}