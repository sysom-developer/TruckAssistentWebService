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
        $obd_device_no = trim($this->input->get_post('obd_device_no', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(1399, 'driver_id 参数错误');
            exit;
        }

        if (empty($obd_device_no)) {
            $this->app_error_func(6666, '输入obd设备号');
            exit;
        }

        $where = [
            'driver_id' => $this->data['driver_id']
        ];

        $data = [
            'obd_device_no' => $obd_device_no,
        ];

        $this->common_model->update('obd_device', $data, $where);

        echo json_en($this->data['error']);
        exit;
    }
}