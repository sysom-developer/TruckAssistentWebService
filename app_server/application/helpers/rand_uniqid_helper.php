<?php

/**
 * 
 * 生成唯一随机数，并md5返回
 */
if ( ! function_exists('rand_uniqid'))
{
    function rand_uniqid() {
        mt_srand();
        $rand_uniqid = md5(uniqid(mt_rand())).date("YmdHis");

        return $rand_uniqid;
    }
}