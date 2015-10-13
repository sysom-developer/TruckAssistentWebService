<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_interface extends Public_Android_Controller {

    public function index()
    {
        $this->data['title'] = '公版APP接口测试';

        $this->load->view($this->appfolder.'/test_interface_view', $this->data);
    }
}