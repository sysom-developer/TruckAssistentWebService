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

        $data = $this->waybill_service->get_waybill($driver_id, $type);
        $this->data['error']['body']['waybill'] = $data;
        echo json_en($this->data['error']);
        exit;

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
            'current_address' => 'xxx地址'
        ];
        $consumption = [
            ['mileage_id'=>1, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.3, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>2, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.4, 'mileage' => 30, 'traffic' => '平路'],
            ['mileage_id'=>3, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.5, 'mileage' => 40, 'traffic' => '平路'],
            ['mileage_id'=>4, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.6, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>5, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.7, 'mileage' => 20, 'traffic' => '平路'],
            ['mileage_id'=>6, 'start_address' => 'xxx地址', 'end_address' => 'asxxx地址', 'start_time' => 1448557261, 'end_time' => 1448564461, 'amount_per_km' => 2.8, 'mileage' => 40, 'traffic' => '平路'],

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

        $all_city = [
            ['city_id' => 1, 'city_value' => '鞍山', 'city_pinyin'=> 'anshan'],
            ['city_id' => 2, 'city_value' => '北京', 'city_pinyin'=> 'beijing']
        ];

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
        $year = trim($this->input->get_post('year', true));
        $month = trim($this->input->get_post('month', true));

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

        $data = $this->waybill_service->get_waybill_data_list($driver_id, $offset, $limit, $year, $month, $type);
        $this->data['error']['body']['data'] = $data;
        echo json_en($this->data['error']);
        exit;


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


        $waybill = [
            'base' => $base
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

    public function get_tracking(){
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
            'type'=> 1,

        ];


        $speed_ratio= [
            ['economic_speed' => '60-80', 'ratio' => 0.75],
            ['high_speed' => '80-', 'ratio' => 0.1],
            ['slow_speed' => '-60', 'ratio' => 0.15],
        ];

        $tracking = [
            ['longitude' => 121.604924, 'ew_indicator' => '45', 'latitude' => 31.282053, 'ns_indicator' => '4e', 'time' => 1448600020],
            ['longitude' => 121.605203, 'ew_indicator' => '45', 'latitude' => 31.281904, 'ns_indicator' => '4e', 'time' => 1448601722],
            ['longitude' => 114.7689,   'ew_indicator' => '45', 'latitude' => 32.280327, 'ns_indicator' => '4e', 'time' => 1449107905],
            ['longitude' => 105.270138, 'ew_indicator' => '45', 'latitude' => 32.149730, 'ns_indicator' => '4e', 'time' => 1449194171],
            ['longitude' => 105.121904, 'ew_indicator' => '45', 'latitude' => 32.17897,  'ns_indicator' => '4e', 'time' => 1449195250],
            ['longitude' => 105.9234,   'ew_indicator' => '45', 'latitude' => 31.888799, 'ns_indicator' => '4e', 'time' => 1449196048],
        ];

        $consumption_factor = [
            ['consumption_factor_type'=>1],
            ['consumption_factor_type'=>2],
            ['consumption_factor_type'=>3],
            ['consumption_factor_type'=>4],
            ['consumption_factor_type'=>5],
        ];

        $waybill = [
            'base' => $base,
            'speed_ratio' => $speed_ratio,
            'tracking' => $tracking,
            'consumption_factor' => $consumption_factor
        ];
        $this->data['error']['body']['waybill'] =  $waybill;

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 获取所有油耗因子
     */
    public function get_consumption_factor(){

        $consumption_factor = [
            ['consumption_factor_type'=>1, 'name' => '怠速区'],
            ['consumption_factor_type'=>2, 'name' => '一般经济区'],
            ['consumption_factor_type'=>3, 'name' => '低速空档'],
            ['consumption_factor_type'=>4, 'name' => '全油门'],
            ['consumption_factor_type'=>5, 'name' => '急刹车'],
        ];

        $this->data['error']['body']['consumption_factor'] =  $consumption_factor;

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 油耗分析
     */
    public function get_consumption_analysis(){

        $factor = [
            ['factor_type'=>1, 'factor_value' => '油耗top1原因'],
        ];

        $contrast = [
            'average' => 38.4,
            'current' => 42.6,
            'friend' => 36.8
        ];

        $this->data['error']['body']['data'] =  [
            'factor' => $factor,
            'contrast' => $contrast
        ];

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 油耗分析
     */
    public function depth_report(){

        $depth_report = [
            ['consumption_factor_type'=>1, 'name' => '怠速区', 'value' => '下降'],
            ['consumption_factor_type'=>2, 'name' => '一般经济区', 'value' => '下降'],
            ['consumption_factor_type'=>3, 'name' => '低速空档', 'value' => '下降'],
            ['consumption_factor_type'=>4, 'name' => '全油门', 'value' => '下降'],
            ['consumption_factor_type'=>5, 'name' => '急刹车', 'value' => '下降'],
        ];
        $this->data['error']['body']['depth_report'] =  $depth_report;

        echo json_en($this->data['error']);
        exit;
    }

    public function get_trucking_by_consumption(){
        $tracking = [
            ['longitude' => 121.604924, 'ew_indicator' => '45', 'latitude' => 31.282053, 'ns_indicator' => '4e', 'time' => 1448600020],
            ['longitude' => 121.605203, 'ew_indicator' => '45', 'latitude' => 31.281904, 'ns_indicator' => '4e', 'time' => 1448601722],
            ['longitude' => 114.7689,   'ew_indicator' => '45', 'latitude' => 32.280327, 'ns_indicator' => '4e', 'time' => 1449107905],
            ['longitude' => 105.270138, 'ew_indicator' => '45', 'latitude' => 32.149730, 'ns_indicator' => '4e', 'time' => 1449194171],
            ['longitude' => 105.121904, 'ew_indicator' => '45', 'latitude' => 32.17897,  'ns_indicator' => '4e', 'time' => 1449195250],
            ['longitude' => 105.9234,   'ew_indicator' => '45', 'latitude' => 31.888799, 'ns_indicator' => '4e', 'time' => 1449196048],
        ];
        $base=[
            'time' => 2,
            'start_time' => 3213232,
            'end_time' => 321321312,
        ];
        $address = [
            ['start_time' => 32321, 'end_time' => 32312, 'start_address' => 'xxxx地址', 'end_address' => 'xxx地址'],
            ['start_time' => 32321, 'end_time' => 32312, 'start_address' => 'xxxx地址', 'end_address' => 'xxx地址'],
            ['start_time' => 32321, 'end_time' => 32312, 'start_address' => 'xxxx地址', 'end_address' => 'xxx地址'],
            ['start_time' => 32321, 'end_time' => 32312, 'start_address' => 'xxxx地址', 'end_address' => 'xxx地址']
        ];

        $this->data['error']['body']['data'] =  ['base' => $base, 'tracking' => $tracking, 'address' => $address];

        echo json_en($this->data['error']);
    }
}
