<?php

/**
 * 
 * 根据时间段设置问候语
 */
if ( ! function_exists('greeting'))
{
    function greeting() {
    	$strTimeToString = "000111222334455556666667";
        $strWenhou = array('夜深了，','凌晨了，','早上好！','上午好！','中午好！','下午好！','晚上好！','夜深了，');
        
        return $strWenhou[(int)$strTimeToString[(int)date('G',time())]];
    }
}