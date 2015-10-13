<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods_category_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_goods_category_by_id($id) {
        $where = array(
            'catid' => $id,
        );
        $data = $this->common_model->get_data('goods_category', $where)->row_array();

        return $data;
    }

    public function get_goods_category_data_list($where, $order = 'catid', $by = 'ASC') {
        $data = $this->common_model->get_data('goods_category', $where, '', '', $order, $by)->result_array();

        return $data;
    }

    public function get_goods_category_options($id = 0, $where = array()) {
        $data_list = $this->get_goods_category_data_list($where, 'catid', 'DESC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($id == $data['catid']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['catid'] . " " . $selected . ">" . $data['catname'] . "</option>";
            }
        }

        return $options;
    }

}