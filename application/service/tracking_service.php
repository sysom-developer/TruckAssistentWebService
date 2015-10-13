<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_tracking_data($where, $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        $data = $this->common_model->get_data('tracking', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_tracking_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('tracking', $where)->row_array();

        return $data;
    }

    public function get_tracking_data_list($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        $data_list = $this->common_model->get_data('tracking', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }

}