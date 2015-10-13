<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_score_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_product_score_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('product_score', $where)->row_array();

        return $data;
    }

    public function get_product_score_data_list($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        $where['status'] = 1;
        $data = $this->common_model->get_data('product_score', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

}