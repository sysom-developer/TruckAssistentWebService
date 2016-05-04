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
        $total=array();

        //获取司机id对应的设备号
        $driver_where = ['driver_id' => $driver_id];
        $driver_data = $this->driver_service->get_driver_data($driver_where);
        $device_no = $driver_data['device_no'];

        //根据设备号获取运单
        $waybills =  $this->waybill_model->get_waybill_by_device_no($device_no, $offset, $limit, $start_time_from, $start_time_to,$type);
       
        //格式化运单
        foreach ($waybills as $key => $value) {
            $logic_data=$this->logic_model->get_current_logic($value['device_id'],$value['logic_id']);
            $total_time=empty($value['end_time'])? time()-intval($value['start_time']) : intval($value['end_time'])-intval($value['start_time']);
            $total['consumption_amount']+=$value['consumption_amount'];
            $total['waybill_count']+=1;
            $total['total_mileage']+=intval($value['total_mileage']);
            $total['total_stay']+=$total_time;

            
            if($total['longest_stay']<$total_time)
            {
                $total['longest_stay']=$total_time;
            }
            $base = [
                'waybill_id' => $key,
                'start_time' => $value['start_time'],
                'end_time'   => empty($value['end_time'])? time() : $value['end_time'],
                'start_city' => $value['start_city_name'],
                'end_city'   => $value['end_city_name'],

                'consumption_amount'=>round(floatval($value['consumption_amount']),2),
                'consumption_per_km'=>round(floatval($value['consumption_per_km']),2),
                'amount_per_km'=>round(floatval($value['amount_per_km']),2),
                'total_mileage' =>intval($value['total_mileage']),//总里程
                'average_velocity' =>round(intval($value['total_mileage'])/($total_time/60/60),2),//平均速度
                'stay_time' => $total_time,
                'status' => 1,
                'type'=> 1,
            ];
            $waybills[$key]['base']= $base;
        }
        $total['average_stay']=round($total['total_stay']/$total['waybill_count'],2);
        
        $summary = [
            'waybill_count' => $total['waybill_count'],
            'total_mileage' =>$total['total_mileage'],
            'transport_time' => 245.5*60*60*24,
            'consumption_amount' => round($total['consumption_amount'],2),
            'total_stay' => $total['total_stay'],
            'longest_stay' => $total['longest_stay'],
            'average_stay' => $total['average_stay'],
        ];


        $result = ['waybill_data_list' => $waybills, 'summary' => $summary];
        
        return $result;
    }

    public function get_waybill($driver_id, $type) {

        //获取司机id对应的设备号
        $driver_where = ['driver_id' => $driver_id];
        $driver_data = $this->driver_service->get_driver_data($driver_where);
        $device_no = $driver_data['device_no'];
        $type=1;
        //根据设备号获取运单
        $waybill =  $this->waybill_model->get_current_waybill($device_no,1);
        //格式化运单
        if(!$waybill || $waybill[0]['end_city_name']!=0)
        {
            $waybill = $this->waybill_model->get_current_waybill($device_no,2);
             $type=2;
        }
        $tmp = $waybill[0];
        
        $logic_data=$this->logic_model->get_current_logic($tmp['device_id'],$tmp['logic_id']);
        $consumption = $logic_data['consumption'];
/*        if(is_numeric($tmp['end_city_name']))
        {

            $tmp['end_city_name']=end($consumption)['city'];
            $tmp['end_time']=end($consumption)['end_time'];
        }*/
        $total_time=empty($tmp['end_time'])? time()-intval($tmp['start_time']) : intval($tmp['end_time'])-intval($tmp['start_time']);
        $base = [
            'waybill_id' => json_decode(json_encode( $tmp['_id']),true)['$id'],
            'start_time' => $tmp['start_time'],
            'end_time'   => empty($tmp['end_time'])? time() : $tmp['end_time'],
            'start_city' => $tmp['start_city_name'],
            'end_city'   => $tmp['end_city_name'],

            'consumption_amount'=>round($tmp['consumption_amount'],2),
            'consumption_per_km'=>round($tmp['consumption_per_km'],2),
            'amount_per_km'=>round($tmp['amount_per_km'],2),

            'total_mileage' => intval($tmp['total_mileage']),//总里程
            'average_velocity' => round(intval($tmp['total_mileage'])/($total_time/60/60),2),//平均速度

            'stay_time' =>$total_time,
            'status' => 1,
            'type'=> $type,
            'current_address' => 'xxx地址'
        ];
        /*$tmp['logic_id'] = array_slice($tmp['logic_id'], 0, 100);*/
       
       /* var_dump($consumption);
        exit;*/
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
            'end_city'   => $tmp['end_city_name'],
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


