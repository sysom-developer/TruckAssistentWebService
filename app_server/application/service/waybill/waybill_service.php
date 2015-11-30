<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Waybill_service extends Service {

    public function __construct() {
        parent::__construct();
    }


    /**
     * 根据条件获取运单列表
     * @param array $where
     * @param string $limit
     * @param int $offset
     * @param string $order
     * @param string $by
     * @return mixed
     */
    public function get_waybill_data_list($where = array(), $limit = '', $offset = 0, $order = 'waybill_id', $by = 'desc') {
        $data = $this->common_model->get_data('waybill', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

    public function update_waybill_data($where = array(), $data = '')
    {
        $result = $this->common_model->update('waybill', $data, $where);

    }


    }