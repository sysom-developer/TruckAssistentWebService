<?php

use Workerman\Worker;
use comm\Handler;

require_once __DIR__ . '/autoload.php';


// 创建一个Worker监听2346端口，使用websocket协议通讯
$tcp_worker = new Worker("tcp://0.0.0.0:2346");

// 启动4个进程对外提供服务
$tcp_worker->count = 4;


$tcp_worker->onWorkerStart = function($worker)
{
    echo "Worker starting...\n";
};

$tcp_worker->onConnect = function($connection)
{
    echo "New connection...". "\n";
    $connection->send('hello connected..' . "\n");

};

// 当收到客户端发来的数据后返回hello $data给客户端
$tcp_worker->onMessage = function($connection, $data)
{

    global $error_code;
    $socket_data = '4C534A41313645395841474131343731031C32CE10010000';

    if($socket_data != $error_code['SEP']){
        $result = Handler::exe($socket_data);
        $connection->send($result. "\n");
    }

};

// 运行
Worker::runAll();