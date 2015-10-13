<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipper_company_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_shipper_company_data($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        $data = $this->common_model->get_data('shipper_company', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_shipper_company_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('shipper_company', $where)->row_array();

        return $data;
    }

    public function get_shipper_company_data_list($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        $data = $this->common_model->get_data('shipper_company', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

    public function get_shipper_company_options($id = 0) {
        $data_list = $this->get_shipper_company_data_list(array(), '', '', 'id', 'ASC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($id == $data['id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['id'] . " " . $selected . ">" . $data['shipper_company_name'] . "</option>";
            }
        }

        return $options;
    }

    public function driver_first_finished_order($driver_id, $order_id)
    {
        $where = array(
            'driver_id' => $driver_id,
            'order_type' => 5,
        );
        $driver_order_data = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
        if (empty($driver_order_data)) {
            $order_data = $this->orders_service->get_orders_by_id($order_id);
            $shipper_info = $this->shipper_service->get_shipper_by_id($order_data['shipper_id']);
            $shipper_info['shipper_company_data'] = $this->shipper_company_service->get_shipper_company_by_id($shipper_info['company_id']);
            // 增加积分
            $this->update_shipper_company_score($shipper_info, 3);
        }
    }

    public function day_get_score($shipper_info)
    {
        $time = time();
        
        if (
            // 首次进入
            $shipper_info['shipper_company_data']['last_get_score_time'] == 0
            ||
            // 当前时间如果和最后一次记录时间不相等
            date('d', $time) != date('d', $shipper_info['shipper_company_data']['last_get_score_time'])
        ) {
            // 增加积分
            $this->update_shipper_company_score($shipper_info, 4);

            $data = array(
                'last_get_score_time' => $time,
            );
            $where = array(
                'id' => $shipper_info['shipper_company_data']['id'],
            );
            $this->common_model->update('shipper_company', $data, $where);
        }
    }

    public function update_shipper_company_score($shipper_info, $set_type)
    {
        $this->load->config('shipper_company_score_config');
        $shipper_company_score_config = $this->config->item('shipper_company_score_config');

        $score_num = FALSE;
        if (isset($shipper_company_score_config[$set_type]['score_num'])) {
            $score_num = $shipper_company_score_config[$set_type]['score_num'];
        }

        if ($score_num === FALSE) {
            return FALSE;
        }

        $time = time();

        $where = array(
            'id' => $shipper_info['company_id'],
        );
        $this->db->set('shipper_company_score', 'shipper_company_score + ' . $score_num, FALSE)->where($where)->update('shipper_company');

        // 写入日志
        $update_score = $shipper_info['shipper_company_data']['shipper_company_score'] + $score_num;
        $data = array(
            'shipper_company_id' => $shipper_info['company_id'],
            'shipper_id' => $shipper_info['shipper_id'],
            'set_type' => $set_type,
            'score_num' => $score_num,
            'update_score' => $update_score,
            'cretime' => $time,
        );
        $this->common_model->insert('shipper_company_score_log', $data);

        return TRUE;
    }

}