<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obd_device_service extends Service {

    public function __construct() {
        parent::__construct();
    }



    /**
     * 根据条件获取obd设备列表信息
     * @param $where
     * @return mixed
     */
    public function get_obd_device_data($where) {
        $data = $this->common_model->get_data('obd_device', $where)->row_array();

        return $data;
    }

}