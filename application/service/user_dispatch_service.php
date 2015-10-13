<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_dispatch_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_user_dispatch_by_id($id) {
        $where = array(
            'id' => $id,
            'status' => 1,
        );
        $data = $this->common_model->get_data('user_dispatch', $where)->row_array();

        return $data;
    }

    public function get_user_dispatch_data_list($order = 'id', $by = 'ASC') {
        $where = array(
            'status' => 1,
        );
        $data = $this->common_model->get_data('user_dispatch', $where, '', '', $order, $by)->result_array();

        return $data;
    }

    public function get_user_dispatch_options($id = 0) {
        $data_list = $this->get_user_dispatch_data_list('id', 'DESC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($id == $data['id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['id'] . " " . $selected . ">" . $data['username'] . "</option>";
            }
        }

        return $options;
    }

}