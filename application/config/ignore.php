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
    'tube_car' => array(
        'index',
    ),
    'join_team' => array(
        'index',
    ),
    'help' => array(
        'index',
    ),
    'attention' => array(
        'index',
    ),
    'login' => array(
        'index',
        'ajax_do_login',
    ),
    'register' => array(
        'index',
        'ajax_do_reg',
        'company_user',
        'ajax_do_reg_company',
    ),
    'smsseccode' => array(
        'index',
        'get_sms_seccode',
        'get_manager_seccode',
        'ajax_verify_sms_seccode',
    ),
    'forget_pwd' => array(
        'index',
        'reset_password',
    ),
    'upload_file' => array(
        'index',
    ),
);