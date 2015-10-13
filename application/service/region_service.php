<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_region_data($where) {
        $data = $this->common_model->get_data('region', $where)->row_array();

        return $data;
    }

    public function get_region_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('region', $where)->row_array();

        return $data;
    }

    public function get_region_data_list($where = array(), $order = 'id', $by = 'ASC', $limit = '', $offset = '') {
        $data_list = $this->common_model->get_data('region', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }

    public function get_region_options($id = 0, $where = array()) {
        $data_list = $this->get_region_data_list($where, 'id', 'ASC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($id == $data['id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['id'] . " " . $selected . ">" . $data['region_name'] . "</option>";
            }
        }

        return $options;
    }

}