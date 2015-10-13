<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Route_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_route_data($where) {
        $data = $this->common_model->get_data('route', $where)->row_array();

        return $data;
    }

    public function get_route_by_id($route_id) {
        $where = array(
            'route_id' => $route_id,
        );
        $data = $this->common_model->get_data('route', $where)->row_array();

        return $data;
    }

    public function get_route_data_list($where = array(), $order = 'route_id', $limit = '', $offset = '', $by = 'ASC') {
        $where = array();
        $data_list = $this->common_model->get_data('route', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }

    public function get_route_options($id = 0) {
        $data_list = $this->get_route_data_list();
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($id == $data['route_id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['route_id'] . " " . $selected . ">" . $data['route_name'] . "</option>";
            }
        }

        return $options;
    }

}