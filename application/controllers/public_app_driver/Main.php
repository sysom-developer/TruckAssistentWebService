<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => '',
                ),
            ),
            'body' => array(),
        );
    }

    public function index()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
            'order_type' => 5,
        );

        // 完成订单总数
        $data_list = $this->orders_service->get_orders_data_list($where);
        $this->data['error']['body']['order_total'] = count($data_list);

        // 当前是否有在途订单
        $where = array(
            'driver_id' => $this->data['driver_id'],
            'order_type' => 4,
        );
        $order_data = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
        $this->data['error']['body']['track_data'] = array();
        if (!empty($order_data)) {
            $this->data['error']['body']['order_data'] = array();

            $this->data['error']['body']['order_data']['order_id'] = $order_data['order_id'];

            $this->data['error']['body']['order_data']['start_location'] = $order_data['order_start_city'].$order_data['good_load_addr'];
            $this->data['error']['body']['order_data']['end_location'] = $order_data['order_end_city'].$order_data['good_unload_addr'];
            
            $this->data['error']['body']['order_data']['start_location_lat'] = $order_data['start_location_lat'];
            $this->data['error']['body']['order_data']['start_location_lng'] = $order_data['start_location_lng'];
            $this->data['error']['body']['order_data']['end_location_lat'] = $order_data['end_location_lat'];
            $this->data['error']['body']['order_data']['end_location_lng'] = $order_data['end_location_lng'];

            $this->data['error']['body']['track_data'] = $this->orders_service->get_track_by_id($order_data['order_id']);
        }

        echo json_en($this->data['error']);
        exit;
    }
}