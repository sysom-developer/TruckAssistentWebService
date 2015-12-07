<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My extends Public_Android_Controller {

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

    /**
     * 根据司机id获取自己资料
     */
    public function index()
    {
        $driver_id = trim($this->input->get_post('type', true));;


        $data = [
            'driver_id' => 90,
            'name' => 'llldd',
            'driver_head_icon' => 'xxx',
            'login_name' => '13486750875'
        ];

        $this->data['error']['body']['data'] = $data;

        echo json_en($this->data['error']);
        exit;
    }

    public function update_head_icon(){
        echo json_en($this->data['error']);
        exit;
    }

    public function update_nick_name(){
        echo json_en($this->data['error']);
        exit;
    }

    public function update_pwd(){
        echo json_en($this->data['error']);
        exit;
    }

}
