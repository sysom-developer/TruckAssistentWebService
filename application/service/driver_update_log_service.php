<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_update_log_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_driver_update_log_data($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'DESC') {
        $data = $this->common_model->get_data('driver_update_log', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_driver_update_log_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('driver_update_log', $where)->row_array();

        return $data;
    }

    public function get_driver_update_log_data_list($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'DESC') {
        $data_list = $this->common_model->get_data('driver_update_log', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }
    
}