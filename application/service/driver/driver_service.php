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



    public function get_driver_address_data_list($where, $limit = '', $offset = 0, $order = 'id', $by = 'ASC') {
        $data = $this->common_model->get_data('driver_address', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

    /**
     * 获取司机历史城市
     * @param $driver_id
     * @param $count
     */
    public function get_history_city($driver_id, $count){
        $where['driver_id'] = $driver_id;
        $limit = $count;
        $data = $this->common_model
            ->select('end_city_id')
            ->group_by('end_city_id')
            ->get_data('waybill', $where, $limit, $offset = 0, $order = 'create_time', $by = 'DESC' )
            ->result_array();
        $ids = array_column($data, 'end_city_id');

        unset($data);
        $data = $this->city_service->get_city_by_ids($ids);

//        echo $this->db->last_query();

        return $data;
    }

}