<?php
require_once __DIR__ . '/../autoload.php';

use comm\Cache\MyRedis;

$my_redis = MyRedis::getInstance();

$last_time = $my_redis->set('last_time', time());