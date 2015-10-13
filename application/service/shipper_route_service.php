<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipper_route_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_shipper_route_data($where) {
        $data = $this->common_model->get_data('shipper_route', $where)->row_array();

        return $data;
    }

    public function get_shipper_route_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('shipper_route', $where)->row_array();

        return $data;
    }

    public function get_shipper_route_data_list($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        $data_list = $this->common_model->get_data('shipper_route', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }

    public function get_shipper_route_options($where = array(), $id = 0) {
        $data_list = $this->get_shipper_route_data_list($where);
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($id == $data['route_id']) {
                    $selected = 'selected';
                }

                $route_data = $this->route_service->get_route_by_id($data['route_id']);

                $options .= "<option value=" . $route_data['route_id'] . " " . $selected . ">" . $route_data['route_name'] . "</option>";
            }
        }

        return $options;
    }

}