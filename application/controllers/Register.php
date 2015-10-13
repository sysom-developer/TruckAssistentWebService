<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Public_Controller {

    public function index()
    {
        $this->data['title'] = '注册';

        $this->load->view('register_view', $this->data);
    }
}