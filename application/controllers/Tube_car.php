<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tube_car extends Public_Controller {

    public function index()
    {
        $this->data['title'] = '我要管车';

        $this->load->view('tube_car_view', $this->data);
    }
}