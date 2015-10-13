<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_city_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('city', $where)->row_array();

        return $data;
    }

    public function get_city_data_list($order = 'id', $by = 'ASC') {
        $where = array();
        $data = $this->common_model->get_data('city', $where, '', '', $order, $by)->result_array();

        return $data;
    }

}