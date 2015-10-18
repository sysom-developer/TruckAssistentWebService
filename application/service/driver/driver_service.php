<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_driver_data($where = array(), $limit = '', $offset = '', $order = 'driver_id', $by = 'ASC') {
        // $where['driver_type'] = 1;
        
        $data = $this->common_model->get_data('driver', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_driver_by_id($driver_id) {
        $where = array(
            'driver_id' => $driver_id,
            'driver_status' => 1,
            // 'driver_type' => 1,
        );
        $data = $this->common_model->get_data('driver', $where)->row_array();

        return $data;
    }

    public function get_driver_data_list($where, $limit = '', $offset = 0, $order = 'driver_id', $by = 'ASC') {
        $where['driver_status'] = 1;
        // $where['driver_type'] = 1;

        if ($limit) {
            $data = $this->common_model->get_data('driver', $where, $limit, $offset, $order, $by)->result_array();
        } else {
            $data = $this->common_model->get_data('driver', $where, '', '', $order, $by)->result_array();
        }

        return $data;
    }

    public function get_driver_options($where = array(), $driver_id = 0) {
        $data_list = $this->get_driver_data_list($where, 'driver_id', 'DESC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($driver_id == $data['driver_id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['driver_id'] . " " . $selected . ">" . $data['driver_name'] . "</option>";
            }
        }

        return $options;
    }

    public function get_driver_address_data_list($where, $limit = '', $offset = 0, $order = 'id', $by = 'ASC') {
        $data = $this->common_model->get_data('driver_address', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

    public function update_driver_score($driver_id, $set_type)
    {
        $this->load->config('driver_score_config');
        $driver_score_config = $this->config->item('driver_score_config');

        $score_num = FALSE;
        if (isset($driver_score_config[$set_type]['score_num'])) {
            $score_num = $driver_score_config[$set_type]['score_num'];
        }

        if ($score_num === FALSE) {
            return FALSE;
        }

        $where = array(
            'driver_id' => $driver_id,
        );
        $driver_data = $this->get_driver_by_id($driver_id);

        $time = time();
        
        $where = array(
            'driver_id' => $driver_id,
        );
        $this->db->set('driver_score', 'driver_score + ' . $score_num, FALSE)->where($where)->update('driver');

        // 写入日志
        $update_score = $driver_data['driver_score'] + $score_num;
        $data = array(
            'driver_id' => $driver_data['driver_id'],
            'set_type' => $set_type,
            'score_num' => $score_num,
            'update_score' => $update_score,
            'cretime' => $time,
        );
        $this->common_model->insert('driver_score_log', $data);

        $rtn_data = array(
            'history_count_score' => $driver_data['driver_score'],
            'update_score' => $score_num,
        );

        return $rtn_data;
    }

    public function exchange_driver_score($driver_id, $exchange_num)
    {
        $where = array(
            'driver_id' => $driver_id,
        );
        $driver_data = $this->get_driver_by_id($driver_id);

        $time = time();
        
        $where = array(
            'driver_id' => $driver_id,
        );
        $this->db->set('driver_score', 'driver_score - ' . $exchange_num, FALSE)->where($where)->update('driver');

        // 写入日志
        $update_score = $driver_data['driver_score'] - $exchange_num;
        $data = array(
            'driver_id' => $driver_data['driver_id'],
            'set_type' => 0,
            'score_num' => $exchange_num,
            'update_score' => $update_score,
            'cretime' => $time,
        );
        $this->common_model->insert('driver_score_log', $data);

        $rtn_data = array(
            'history_count_score' => $driver_data['driver_score'],
            'update_score' => $update_score,
        );

        return $rtn_data;
    }

}