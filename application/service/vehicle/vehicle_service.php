<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_service extends Service {

    public function __construct() {
        parent::__construct();
    }


    /**
     * 根据车辆id获取车辆信息
     * @param $vehicle_id
     * @return mixed
     */
    public function get_vehicle_by_id($vehicle_id) {
        $where = array(
            'vehicle_id' => $vehicle_id,
            'vehicle_status' => 1,
        );
        $data = $this->common_model->get_data('vehicle', $where)->row_array();

        return $data;
    }

    /**
     * 根据条件获取车辆列表信息
     * @param $where
     * @return mixed
     */
    public function get_vehicle_data($where) {
        $where['vehicle_status'] = 1;
        $data = $this->common_model->get_data('vehicle', $where)->row_array();

        return $data;
    }











    public function get_vehicle_data_list($where = array(), $limit = '', $offset = 0, $order = 'vehicle_id', $by = 'ASC') {
        $where['vehicle_status'] = 1;
        $data = $this->common_model->get_data('vehicle', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

}