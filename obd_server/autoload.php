<?php


require_once __DIR__ . '/lib/SplClassLoader.php';

$classLoader = new SplClassLoader('comm', __DIR__ );
$classLoader->register();

/**
 * 加载 autoload
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * 加载命令表
 */
$command_table = require_once __DIR__ . '/config/command_table.php';

/**
 * 加载指令解码集
 */
$error_code = require_once __DIR__ . '/config/error_code.php';

$conf = require_once __DIR__ . '/config/app_conf.php';

