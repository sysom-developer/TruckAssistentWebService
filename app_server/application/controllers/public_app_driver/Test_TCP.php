<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_TCP extends Public_Android_Controller {

    public function index()
    {


        $data = trim($this->input->get_post('data', TRUE));

        $ip = 'www.tuhaoyun.com.cn';
        $port = '2346';
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if($socket < 0){
            echo '创建socket失败';exit;
        }else{
            echo  '创建socket成功'. '<br/>';
        }

        $result = socket_connect($socket, $ip, $port);

        //序列化
//        $socket_serialize = serialize($socket);
//        $this->load->driver('cache');
//        $this->cache->redis->save('socket', $socket_serialize, 100);


        if($result < 0){
            echo '连接远程服务器失败';exit;
        }else{
            $rev = '';
            $buf = socket_read($socket, 4096, PHP_NORMAL_READ);
            $rev .= $buf;

            echo '连接成功,服务端返回:'. $rev;

//            $ff = String2Hex($data);
//
//            var_dump($ff);
//
//            socket_write($socket, $ff, 4);
        }

    }

    public function get_socket()
    {
        $this->load->driver('cache');
        $socket_serialize = $this->cache->redis->get('socket');
        $socket = unserialize($socket_serialize );


        socket_write($socket, 'ffff', 4);
        $buf = socket_read($socket, 4096, PHP_NORMAL_READ);
        echo '写入成功,服务端返回:'. $buf;exit;



//        if($result < 0){
//            echo '连接远程服务器失败';exit;
//        }else{
//            $rev = '';
//            $buf = socket_read($socket, 4096, PHP_NORMAL_READ);
//            $rev .= $buf;
//
//            echo '连接成功,服务端返回:'. $rev;exit;
//        }

    }


//
//    public function login(){
//        $this->data['title'] = '登录注册模块，公版APP接口测试';
//
//        $this->load->view($this->appfolder.'/test_login', $this->data);
//    }
//
//    public function waybill(){
//        $this->data['title'] = '运单模块，公版APP接口测试';
//
//        $this->load->view($this->appfolder.'/test_waybill', $this->data);
//    }
//
//    public function obd_server(){
//        $this->data['title'] = 'RTOS模块，公版APP接口测试';
//        $this->load->view($this->appfolder.'/test_obd_server', $this->data);
//    }
}