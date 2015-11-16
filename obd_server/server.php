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
    $socket_data = file_get_contents('../logs/16/log1447641247');
    $result = Handler::exe($socket_data, '00');
    var_dump($result);

};

$tcp_worker->onConnect = function($connection)
{

    echo "New connection...". "\n";
    $connection->send('hello connected..' . "\n");

};

// 当收到客户端发来的数据后返回hello $data给客户端
$tcp_worker->onMessage = function($connection, $data)
{


    $socket_data  = $data;



    //接受的二进制数据存入文件
    $base = '/var/obd_logs/';
    $str_time=date('Y-m-d',time());
    $path = $base. str_replace('-', '/', $str_time);
    if (!is_dir($path)){
        mkdir(iconv("UTF-8", "GBK", $path), 0777, true);
    }
    $log_name = $path.'/' . 'log'.time();
    file_put_contents ( $log_name, $data );


    //解析后的结果存入文件
    $data_file_name = $log_name. '_data';
    $result = Handler::exe($socket_data, $data_file_name);

    if($result != false){
        //ack存入文件
        $fid_ack_file_name = $log_name. '_fid_ack';
        file_put_contents($fid_ack_file_name, $result);
        $connection->send($result);

    }

};

// 运行
Worker::runAll();