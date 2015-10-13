<?php 

/**
 * 
 * 前台不需要验证登录的控制器或方法
 */

$config['ignore_login'] = array(
    FALSE,
    'main' => array(
        'index',
    ),
    'invite' => array(
        'index',
        'ajax_do_reg',
    ),
    'smsseccode' => array(
        'index',
        'get_sms_seccode',
    ),
);