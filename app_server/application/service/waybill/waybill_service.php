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
                'end_time'   => empty($tmp['end_time'])? time() : $tmp['end_time'],
                'start_city' => $tmp['start_city_name'],
                'end_city'   => $tmp['end_city'],

                'consumption_amount'=>1950,
                'consumption_per_km'=>36,
                'amount_per_km'=>2.1,
                'total_mileage' => 1200,//总里程
                'average_velocity' => 75.5,//平均速度
                'stay_time' => 60*60*3,
                'status' => 1,
                'type'=> 1,
            ];
            $v = ['base' => $base];

        });

        $summary = [
            'waybill_count' => 8,
            'total_mileage' => 21200,
            'transport_time' => 245.5*60*60*24,
            'consumption_amount' => 27500,
            'total_stay' => 6.5*60*60*24,
            'longest_stay' => 3.5*60*60*24,
            'average_stay' => 2.5*60*60*24,
        ];


        $result = ['waybill_data_list' => $waybills, 'summary' => $summary];
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
            'end_time'   => empty($tmp['end_time'])? time() : $tmp['end_time'],
            'start_city' => $tmp['start_city_name'],
            'end_city'   => $tmp['end_city_name'],

            'consumption_amount'=>1950,
            'consumption_per_km'=>36,
            'amount_per_km'=>2.1,

            'total_mileage' => 1200,//总里程
            'average_velocity' => 75.5,//平均速度

            'stay_time' => 60*60*3,
            'status' => 1,
            'type'=> 1,
            'current_address' => 'xxx地址'
        ];

        $consumption = $this->logic_model->get_current_logic($tmp['device_id'],$tmp['logic_id']);

        //根据运单id获取行程数据
/*        $consumption = [
            ['mileage_id'=>1, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.3, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>2, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.4, 'mileage' => 30, 'traffic' => '平路'],
            ['mileage_id'=>3, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.5, 'mileage' => 40, 'traffic' => '平路'],
            ['mileage_id'=>4, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.6, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>5, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.7, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>6, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.8, 'mileage' => 40, 'traffic' => '平路'],

        ];*/
        $waybill = ['base' => $base,'consumption' => $consumption];

        return $waybill;
    }

    public function get_waybill_by_id($waybill_id){
        //根据运单id获取运单
        $waybill =  $this->waybill_model->get_waybill_by_id($waybill_id);
        $tmp = $waybill;
        $base = [
            'waybill_id' => json_decode(json_encode( $tmp['_id']),true)['$id'],
            'start_time' => $tmp['start_time'],
            'end_time'   => empty($tmp['end_time'])? time() : $tmp['end_time'],
            'start_city' => $tmp['start_city_name'],
            'end_city'   => $tmp['end_city'],


            'consumption_amount'=>1950,
            'consumption_per_km'=>36,
            'amount_per_km'=>2.1,
            'total_mileage' => 1200,//总里程
            'average_velocity' => 75.5,//平均速度
            'stay_time' => 60*60*3,
            'status' => 1,
            'type'=> 1,
        ];


        //根据运单id获取行程数据
        $consumption = [
            ['mileage_id'=>1, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.3, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>2, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.4, 'mileage' => 30, 'traffic' => '平路'],
            ['mileage_id'=>3, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.5, 'mileage' => 40, 'traffic' => '平路'],
            ['mileage_id'=>4, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.6, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>5, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.7, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>6, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.8, 'mileage' => 40, 'traffic' => '平路'],

        ];

        $waybill = ['base' => $base,'consumption' => $consumption];

        return $waybill;
    }



    public function update_waybill_data($where = array(), $data = '')
    {
        $result = $this->common_model->update('waybill', $data, $where);

    }


    }


