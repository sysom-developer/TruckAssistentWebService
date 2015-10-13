<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends App_Web_Controller {

    public function index()
    {
        $this->data['title'] = '首页';

        $this->load->view($this->appfolder.'/main_view', $this->data);
    }
}