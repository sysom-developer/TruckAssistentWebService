<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_interface extends Public_Android_Controller {

    public function index()
    {
        $this->data['title'] = '公版APP接口测试';

        $this->load->view($this->appfolder.'/test_interface_view', $this->data);
    }

    public function login(){
        $this->data['title'] = '登录注册模块，公版APP接口测试';

        $this->load->view($this->appfolder.'/test_login', $this->data);
    }

    public function waybill(){
        $this->data['title'] = '运单模块，公版APP接口测试';

        $this->load->view($this->appfolder.'/test_waybill', $this->data);
    }
}