<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Public_Controller {

    public function index()
    {
        $this->data['title'] = '登陆';

        $this->load->view('login_view', $this->data);
    }
}