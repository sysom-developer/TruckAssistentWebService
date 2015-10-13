<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attention extends Public_Controller {

    public function index()
    {
        $this->data['title'] = '关注我们';

        $this->load->view('attention_view', $this->data);
    }
}