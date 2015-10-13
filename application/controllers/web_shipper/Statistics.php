<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends MY_Controller {

    public function index()
    {
        $this->data['title'] = '统计';

        $this->load->view($this->appfolder.'/statistics_view', $this->data);
    }
}