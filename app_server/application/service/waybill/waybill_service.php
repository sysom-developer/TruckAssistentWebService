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
    public function get_waybill_data_list($driver_id, $offset = 0, $limit, $year, $month, $type) {
        //初始化开始结束时间
        $start_time_from = strtotime($year.'-'.$month);
        $start_time_to = strtotime('+1 month', $start_time_from);


        //获取司机id对应的设备号
        $driver_where = ['driver_id' => $driver_id];
        $driver_data = $this->driver_service->get_driver_data($driver_where);
        $device_no = $driver_data['device_no'];

        //根据设备号获取运单
        $waybills =  $this->waybill_model->get_waybill_by_device_no($device_no, $offset, $limit, $start_time_from, $start_time_to);
        //格式化运单
        array_walk($waybills, function(&$v, $k){
            $tmp = $v;
            $base = [
                'waybill_id' => $k,
                'start_time' => $tmp['start_time'],
                'end_time'   => $tmp['end_time'],
                'start_city' => $tmp['start_city_name'],
                'end_city'   => $tmp['end_city']
            ];
            $v = ['base' => $base];

        });
        $result = ['waybill_data_list' => $waybills];
        return $result;
    }

    public function get_waybill($driver_id, $type) {

        //获取司机id对应的设备号
        $driver_where = ['driver_id' => $driver_id];
        $driver_data = $this->driver_service->get_driver_data($driver_where);
        $device_no = $driver_data['device_no'];

        //根据设备号获取运单
        $waybill =  $this->waybill_model->get_current_waybill($device_no);
        //格式化运单

        $tmp = $waybill[0];
        $base = [
            'waybill_id' => json_decode(json_encode( $tmp['_id']),true)['$id'],
            'start_time' => $tmp['start_time'],
            'end_time'   => $tmp['end_time'],
            'start_city' => $tmp['start_city_name'],
            'end_city'   => $tmp['end_city']
        ];
        $waybill = ['base' => $base];

        return $waybill;
    }

    public function get_waybill_by_id($waybill_id){
        //根据运单id获取运单
        $waybill =  $this->waybill_model->get_waybill_by_id($waybill_id);
        $tmp = $waybill;
        $base = [
            'waybill_id' => json_decode(json_encode( $tmp['_id']),true)['$id'],
            'start_time' => $tmp['start_time'],
            'end_time'   => $tmp['end_time'],
            'start_city' => $tmp['start_city_name'],
            'end_city'   => $tmp['end_city']
        ];
        $waybill = ['base' => $base];

        return $waybill;
    }



    public function update_waybill_data($where = array(), $data = '')
    {
        $result = $this->common_model->update('waybill', $data, $where);

    }


    }


