<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Waybill extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => 'success',
                ),
            ),
            'body' => array(),
        );
    }

    /**
     * 当前运单
     */
    public function index()
    {

        $driver_id = trim($this->input->get_post('driver_id', true));

        $type = trim($this->input->get_post('type', true));

        $type = isset($type)? $type : 1;

        $base = [
            'waybill_id' => 1,
            'start_time' => 1448557261,
            'end_time'=>1448564461,

            'start_city' => '上海',
            'end_city' => '成都',

            'consumption_amount'=>1950,
            'consumption_per_km'=>36,
            'amount_per_km'=>2.1,

            'total_mileage' => 1200,//总里程
            'average_velocity' => 75.5,//平均速度

            'stay_time' => 60*60*3,
            'status' => 1,
            'type'=> $type,
        ];
        $consumption = [
            ['mileage_id'=>1, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.3, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>2, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.4, 'mileage' => 30, 'traffic' => '平路'],
            ['mileage_id'=>3, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.5, 'mileage' => 40, 'traffic' => '平路'],
            ['mileage_id'=>4, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.6, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>5, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.7, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>6, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.8, 'mileage' => 40, 'traffic' => '平路'],

        ];

        $waybill = [
            'base' => $base,
            'consumption' => $consumption
        ];

        $this->data['error']['body']['waybill'] = $waybill;

        echo json_en($this->data['error']);
        exit;
    }


    public function get_destination_city(){
        $driver_id = trim($this->input->get_post('driver_id', true));

        if (empty($driver_id) || !is_numeric($driver_id) ) {
            $this->app_error_func(1798, 'driver_id 参数错误');
            exit;
        }

        $history_city = $this->driver_service->get_history_city($driver_id, 10);

        $hot_city = $this->config->item('hot_city', 'city');

        $all_city = ['鞍山', '北京'];

        $data = [
            'history_city' => $history_city,
            'hot_city' => $hot_city,
            'all_city' => $all_city,
        ];

        $this->data['error']['body']['data'] = $data;

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 根据司机id获取运单列表
     */
    public function get_waybill_list()
    {

        $driver_id = trim($this->input->get_post('driver_id', true));
        $type = trim($this->input->get_post('type', true));
        $offset = trim($this->input->get_post('offset', true));
        $limit = trim($this->input->get_post('limit', true));
        $order = trim($this->input->get_post('order', true));
        $by = strtolower(trim($this->input->get_post('by', true)));

        if (empty($driver_id) || !is_numeric($driver_id) ) {
            $this->app_error_func(1499, 'driver_id 参数错误');
            exit;
        }

        if (!is_numeric($offset) ) {
            $this->app_error_func(1498, 'offset 参数错误');
            exit;
        }

        if (!is_numeric($limit) ) {
            $this->app_error_func(1497, 'limit 参数错误');
            exit;
        }


        if(!in_array($type, array('1', '2'))){
            $this->app_error_func(1495, 'type 参数错误');
            exit;
        }

        // 运单信息

        $base = [
            'waybill_id' => 1,
            'start_time' => 1448557261,
            'end_time'=>1448564461,

            'start_city' => '上海',
            'end_city' => '成都',

            'consumption_amount'=>1950,
            'consumption_per_km'=>36,
            'amount_per_km'=>2.1,

            'total_mileage' => 1200,//总里程
            'average_velocity' => 75.5,//平均速度

            'stay_time' => 60*60*3,
            'status' => 1,
            'type'=> $type,
        ];
        $consumption = [
            ['mileage_id'=>1, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.3, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>2, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.4, 'mileage' => 30, 'traffic' => '平路'],
            ['mileage_id'=>3, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.5, 'mileage' => 40, 'traffic' => '平路'],
            ['mileage_id'=>4, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.6, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>5, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.7, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>6, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.8, 'mileage' => 40, 'traffic' => '平路'],

        ];

        $waybill = [
            'base' => $base,
            'consumption' => $consumption
        ];

        $waybill_data_list = [
            $waybill, $waybill, $waybill
        ];

        $summary = [
            'waybill_count' => 8,
            'total_mileage' => 21200,
            'transport_time' => 245.5*60*60*24,
            'consumption_amount' => 27500,
            'total_stay' => 6.5*60*60*24,
            'longest_stay' => 3.5*60*60*24,
            'average_stay' => 2.5*60*60*24,
        ];



        $this->data['error']['body']['data'] = [
            'waybill_data_list'=>$waybill_data_list,
            'summary' => $summary
        ];

        echo json_en($this->data['error']);
        exit;
    }


    /**
     * 更新运单
     */
    public function update_waybill_data()
    {

        $waybill_id = trim($this->input->get_post('waybill_id', true));
        $end_city_id = trim($this->input->get_post('end_city_id', true));


        if (empty($waybill_id) || !is_numeric($waybill_id) ) {
            $this->app_error_func(1699, 'waybill_id 参数错误');
            exit;
        }

        if (!is_numeric($end_city_id) ) {
            $this->app_error_func(1698, 'end_city_id 参数错误');
            exit;
        }

        // 运单信息
        $where = array(
            'waybill_id' => $waybill_id,
        );
        $data = array(
            'end_city_id' => $end_city_id
        );
        $this->waybill_service->update_waybill_data($where, $data);

        echo json_en($this->data['error']);
        exit;
    }


    /**
     * 运单详情
     */
    public function detail()
    {
        $waybill_id = trim($this->input->get_post('waybill_id', true));

        $type = trim($this->input->get_post('type', true));

        $type = isset($type)? $type : 1;

        $base = [
            'waybill_id' => 1,
            'start_time' => 1448557261,
            'end_time'=>1448564461,

            'start_city' => '上海',
            'end_city' => '成都',

            'consumption_amount'=>1950,
            'consumption_per_km'=>36,
            'amount_per_km'=>2.1,

            'total_mileage' => 1200,//总里程
            'average_velocity' => 75.5,//平均速度

            'stay_time' => 60*60*3,
            'status' => 1,
            'type'=> $type,
        ];
        $consumption = [
            ['mileage_id'=>1, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.3, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>2, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.4, 'mileage' => 30, 'traffic' => '平路'],
            ['mileage_id'=>3, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.5, 'mileage' => 40, 'traffic' => '平路'],
            ['mileage_id'=>4, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.6, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>5, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.7, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>6, 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.8, 'mileage' => 40, 'traffic' => '平路'],

        ];

        $waybill = [
            'base' => $base,
            'consumption' => $consumption
        ];

        $this->data['error']['body']['waybill'] = $waybill;

        echo json_en($this->data['error']);
        exit;
    }

}