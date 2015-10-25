<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Node_service extends Service {

    public function __construct() {
        parent::__construct();
    }


    /**
     * 根据条件获取node列表
     * @param array $where
     * @param string $limit
     * @param int $offset
     * @param string $order
     * @param string $by
     * @return mixed
     */
    public function get_node_data_list($where = array(), $limit = '', $offset = 0, $order = 'node_id', $by = 'ASC') {
        $data = $this->common_model->get_data('node', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

}