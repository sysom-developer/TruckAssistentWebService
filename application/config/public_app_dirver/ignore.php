<?php 

/**
 * 
 * 前台不需要验证登录的控制器或方法
 */

$config['ignore_login'] = array(
    FALSE,
    'login' => array(
        'index',
    ),
);