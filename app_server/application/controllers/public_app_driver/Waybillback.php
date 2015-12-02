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

//        if(!in_array($by, array('desc', 'asc'))){
//            $this->app_error_func(1496, 'by 参数错误');
//            exit;
//        }

        if(!in_array($type, array('1', '2'))){
            $this->app_error_func(1495, 'type 参数错误');
            exit;
        }

        // 运单信息
        $where = array(
            'driver_id' => $driver_id,
            'type' => $type

        );
        $waybill_data_list = $this->waybill_service->get_waybill_data_list($where, $limit, $offset, $order, $by);

        $this->data['error']['body']['waybill_data_list'] = $waybill_data_list;

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
     * 根据运单id获取节点列表
     */
    public function get_node_list()
    {

        $waybill_id = trim($this->input->get_post('waybill_id', true));
        $offset = trim($this->input->get_post('offset', true));
        $limit = trim($this->input->get_post('limit', true));
        $order = trim($this->input->get_post('order', true));
        $by = strtolower(trim($this->input->get_post('by', true)));

        if (empty($waybill_id) || !is_numeric($waybill_id) ) {
            $this->app_error_func(1599, 'waybill_id 参数错误');
            exit;
        }

        if (!is_numeric($offset) ) {
            $this->app_error_func(1598, 'offset 参数错误');
            exit;
        }

        if (!is_numeric($limit) ) {
            $this->app_error_func(1597, 'limit 参数错误');
            exit;
        }

        if(!in_array($by, array('desc', 'asc'))){
            $this->app_error_func(1596, 'by 参数错误');
            exit;
        }

        // 节点信息
        $where = array(
            'waybill_id' => $waybill_id,
        );
        $node_data_list = $this->node_service->get_node_data_list($where, $limit, $offset, $order, $by);

        $this->data['error']['body']['node_data_list'] = $node_data_list;

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 热门城市
     */
    public function get_hot_city()
    {
        $data = $this->config->item('hot_city', 'city');
        $this->data['error']['body']['data_list'] =  array_values($data);

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 热门城市
     */
    public function get_history_city()
    {
        $driver_id = trim($this->input->get_post('driver_id', true));
        $count = trim($this->input->get_post('count', true));

        if (empty($count) || !is_numeric($count) ) {
            $this->app_error_func(1799, 'count 参数错误');
            exit;
        }
        if (empty($driver_id) || !is_numeric($driver_id) ) {
            $this->app_error_func(1798, 'driver_id 参数错误');
            exit;
        }

        $data = $this->driver_service->get_history_city($driver_id, $count);

        $this->data['error']['body']['data_list'] =  array_values($data);

        echo json_en($this->data['error']);
        exit;
    }

    public function index()
    {
    }

    /**
     * 运单详情
     */
    public function detail(){
        $waybill_id = trim($this->input->get_post('waybill_id', true));
        if (empty($waybill_id) || !is_numeric($waybill_id) ) {
            $this->app_error_func(1899, 'waybill_id 参数错误');
            exit;
        }

        $base = [
            'waybill_id' => 2,
            'start_city' => '北京',
            'end_city' => '上海',
            'start_time' => 1448557261,
            'end_time'=>1448564461,
            'status' => '0',//状态0-运单进行中，1-运单已结束
            'total_mileage' => 300,//总里程
            'driving_time'  => 20,//驾驶时间
            'estimate_consumption' => 200,//预估油耗
            'average_velocity' => 30,//平均速度
            'save_consumption' => 10,//节省油费
        ];

        $speed_ratio = [
            ['speed_range' => '0-40', 'ratio' => 0.3],
            ['speed_range' => '40-75', 'ratio' => 0.2],
            ['speed_range' => '75-85', 'ratio' => 0.34],
            ['speed_range' => '85-', 'ratio' => 0.16]
        ];

        $service_area = [
            ['id' => 1, 'name' => 'xxx服务区', 'address' => 'xxx地址', 'start_time' => 1448557261, 'end_time'=>1448568061],
            ['id' => 2, 'name' => '2bx服务区', 'address' => 'xxx地址', 'start_time' => 1448575261, 'end_time'=>1448578861],
            ['id' => 3, 'name' => '001服务区', 'address' => 'xxx地址', 'start_time' => 1448611261, 'end_time'=>1448614861],
        ];//服务区

        $toll_station = [
            ['id' => 4, 'name' => 'xxx收费站', 'address' => 'xxx地址', 'start_time' => 1448571661, 'end_time'=>1448575261, 'fee' => 200],
            ['id' => 5, 'name' => '2bx收费站', 'address' => 'xxx地址','start_time' => 1448582461, 'end_time'=>1448586061, 'fee' => 100],
            ['id' => 6, 'name' => '001收费站', 'start_time' => 1448589661, 'end_time'=>1448591401, 'fee' => 50],
        ];//收费站

        $petrol_station = [
            ['id' => 7, 'name' => 'xxx加油站', 'address' => 'xxx地址', 'start_time' => 1448571661, 'end_time'=>1448575261, 'fee' => 50],
            ['id' => 8, 'name' => '2bx加油站', 'address' => 'xxx地址','start_time' => 1448582461, 'end_time'=>1448586061, 'fee' => 100],
            ['id' => 9, 'name' => '001加油站', 'address' => 'xxx地址','start_time' => 1448589661, 'end_time'=>1448591401, 'fee' => 200],
        ];//加油站

        $waybill = [
            'base' => $base,
            'speed_ratio' => $speed_ratio,
            'service_area' => $service_area,
            'toll_station' => $toll_station,
            'petrol_station' => $petrol_station
        ];

        $this->data['error']['body']['waybill'] =  $waybill;

        echo json_en($this->data['error']);
        exit;

    }
}