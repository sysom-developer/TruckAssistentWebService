<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_location_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_vehicle_location_data($where, $limit = '', $offset = '', $order = 'update_time', $by = 'ASC') {
        $data = $this->common_model->get_data('vehicle_location', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_vehicle_location_data_list($where = array(), $limit = '', $offset = '', $order = 'update_time', $by = 'ASC') {
        $data_list = $this->common_model->get_data('vehicle_location', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }

}