<?php

/**
 * 
 * 生成随机数
 */
if ( ! function_exists('random'))
{
    function random($length, $numeric = 1) {
    	$seed = base_convert(do_hash(microtime().$_SERVER['DOCUMENT_ROOT'], 'md5'), 16, $numeric ? 10 : 35);
    	$seed = $numeric ? (str_replace('0', '', $seed).'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789') : ($seed.'zZ'.strtoupper($seed));
    	$hash = '';
    	$max = strlen($seed) - 1;
    	for($i = 0; $i < $length; $i++) {
    		$hash .= $seed{mt_rand(0, $max)};
    	}
    	return $hash;
    }
}