<?php

use Workerman\Worker;
use comm\Handler;
use comm\Byte;

require_once __DIR__ . '/autoload.php';


// 创建一个Worker监听2346端口，使用websocket协议通讯
$tcp_worker = new Worker("tcp://0.0.0.0:2346");

// 启动4个进程对外提供服务
$tcp_worker->count = 1;


$tcp_worker->onWorkerStart = function($worker)
{
    echo "Worker starting...\n";
//    $socket_data = file_get_contents('log38');
//    Handler::exe($socket_data);

};

$tcp_worker->onConnect = function($connection)
{
    echo "New connection...". "\n";
    $connection->send('hello connected..' . "\n");

};

// 当收到客户端发来的数据后返回hello $data给客户端
$tcp_worker->onMessage = function($connection, $data)
{

    $base = '/var/obd_logs/';
    $str_time=date('Y-m-d',time());
    $path = $base. str_replace('-', '/', $str_time);
    if (!is_dir($path)){
        mkdir(iconv("UTF-8", "GBK", $path), 0777, true);
    }
    $log_name = $path.'/' . 'log'.time();
    file_put_contents ( $log_name, $data );

    $socket_data  = $data;
//    $socket_data = file_get_contents('log39');
    $result = Handler::exe($socket_data);
    global $error_code;

    $connection->send($result);
//    if($socket_data != $error_code['SEP']){
//        $result = Handler::exe($socket_data);
//        $connection->send($result. "\n");
//    }

};

// 运行
Worker::runAll();