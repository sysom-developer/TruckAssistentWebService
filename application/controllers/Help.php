<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends Public_Controller {

    public function index()
    {
        $this->data['title'] = '帮助';

        $this->load->view('help_view', $this->data);
    }
}