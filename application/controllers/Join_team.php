<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join_team extends Public_Controller {

    public function index()
    {
        $this->data['title'] = '加入车队';

        $this->load->view('join_team_view', $this->data);
    }
}