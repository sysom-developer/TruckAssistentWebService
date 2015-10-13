<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_message_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_driver_message_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('driver_message', $where)->row_array();

        return $data;
    }

    public function get_driver_message_data_list($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'DESC') {
        $data_list = $this->common_model->get_data('driver_message', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }
    
}