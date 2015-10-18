<?php

if ( ! function_exists('static_url'))
{
    function static_url($file = '') {
        $CI =& get_instance();
        if(preg_match('/^(http|https)\:\/\//', $file))return $file;
        if(!file_exists(BASEPATH.'../'.$file)){
            return base_url($file) . '';
        }else{
        	if(!preg_match('/\.(gif|jpg|png|css|js|swf|ico|jpeg|bmp|eot|ttf|wott|svg)$/i', $file))return false;
            return base_url($file) . '?v=' . substr(md5_file(BASEPATH.'../'.$file), 8, 6);
        }
    }
}