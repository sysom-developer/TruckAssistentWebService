<?php 

/**
 * 多语言种类
 * 'ch' => '中',
 * 'en' => '英',
 * 'ja' => '日',
 * 'fr' => '法',
 * 'ge' => '德',
 * 'it' => '意大利',
 * 'sp' => '西班牙',
 */

if ( ! function_exists('get_lang_type_helper'))
{
    function get_lang_type_helper()
    {
        $CI =& get_instance();
        
        $lang_type = array(
            'ch' => '中',
        );
        
        return $lang_type;
    }
}