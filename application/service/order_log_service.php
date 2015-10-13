<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_log_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_order_log_data($where = array(), $limit = '', $offset = '', $order = 'log_id', $by = 'DESC') {
        $data = $this->common_model->get_data('order_log', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_order_log_by_id($id) {
        $where = array(
            'log_id' => $id,
        );
        $data = $this->common_model->get_data('order_log', $where)->row_array();

        return $data;
    }

    public function get_order_log_data_list($where = array(), $limit = '', $offset = 0, $order = 'log_id', $by = 'DESC') {
        $data = $this->common_model->get_data('order_log', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

}