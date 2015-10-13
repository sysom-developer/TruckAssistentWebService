<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_history_region_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_data($where) {
        $data = $this->common_model->get_data('driver_history_region', $where)->row_array();

        return $data;
    }

    public function get_data_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('driver_history_region', $where)->row_array();

        return $data;
    }

    public function get_data_list($where = array(), $order = 'id', $by = 'ASC', $limit = '', $offset = '') {
        $data_list = $this->common_model->get_data('driver_history_region', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }

}