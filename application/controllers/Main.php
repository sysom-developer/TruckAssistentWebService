<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Public_Controller {

    public function index()
    {
        $this->data['title'] = '首页';

        $this->load->view('main_view', $this->data);
    }
}