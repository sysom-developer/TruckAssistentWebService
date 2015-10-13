<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_score_log_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_driver_score_log_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('driver_score_log', $where)->row_array();

        return $data;
    }

    public function get_driver_score_log_data_list($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'DESC') {
        $data_list = $this->common_model->get_data('driver_score_log', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }
    
}