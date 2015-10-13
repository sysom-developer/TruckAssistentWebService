<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipper_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_shipper_data($where, $limit = '', $offset = '', $order = 'shipper_id', $by = 'ASC') {
        $where['shipper_status'] = 1;
        $data = $this->common_model->get_data('shipper', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_shipper_by_id($id) {
        $where = array(
            'shipper_id' => $id,
            'shipper_status' => 1,
        );
        $data = $this->common_model->get_data('shipper', $where)->row_array();

        return $data;
    }

    public function get_shipper_data_list($where = array(), $limit = '', $offset = '', $order = 'shipper_id', $by = 'ASC') {
        $where['shipper_status'] = 1;
        $data_list = $this->common_model->get_data('shipper', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }

    public function get_shipper_options($where = array(), $id = 0) {
        $data_list = $this->get_shipper_data_list($where, '', '', 'shipper_id', 'DESC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($id == $data['shipper_id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['shipper_id'] . " " . $selected . ">" . $data['shipper_name'] . "</option>";
            }
        }

        return $options;
    }

}