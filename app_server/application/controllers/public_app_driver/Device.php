<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => 'success',
                ),
            ),
            'body' => array(),
        );
    }


    public function get_device_information()
    {
        $data = [
            'obd_device_no' => 'obd_121231244',
        ];
        $this->data['error']['body']['data'] =  $data;

        echo json_en($this->data['error']);
        exit;
    }

    public function relieve_device(){
        echo json_en($this->data['error']);
        exit;
    }
}