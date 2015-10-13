<?php 

/**
 *
 * 后台不需要验证登录的控制器或方法
 */

$config['ignore_login'] = array(
	FALSE,
	'login' => array(
		'index',
		'act_login',
	),
	'secode' => array(
	    'index',
	),
	'logout' => array(
		'index',
	),
	'upload_file' => array(
		'editor_image',
	),
);

?>