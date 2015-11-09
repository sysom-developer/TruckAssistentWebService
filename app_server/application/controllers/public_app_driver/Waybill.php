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

        if(!in_array($by, array('desc', 'asc'))){
            $this->app_error_func(1496, 'by 参数错误');
            exit;
        }

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
}