<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Public_Android_Controller {

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

    public function add_data()
    {
        $shipper_id = $this->input->get_post('shipper_id', TRUE);
        $shipper_id = !empty($shipper_id) ? $shipper_id : 11;

        $start_city_id = $this->input->get_post('start_city_id', TRUE);
        $start_lat = $this->input->get_post('start_lat', TRUE);
        $start_lng = $this->input->get_post('start_lng', TRUE);
        // $start_location = $this->input->get_post('start_location', TRUE);

        $end_city_id = $this->input->get_post('end_city_id', TRUE);
        $end_lat = $this->input->get_post('end_lat', TRUE);
        $end_lng = $this->input->get_post('end_lng', TRUE);
        // $end_location = $this->input->get_post('end_location', TRUE);

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (empty($start_city_id) || empty($start_lat) || empty($start_lng)) { // || empty($start_location)
            $this->app_error_func(997, '起点地址无效');
            exit;
        }

        if (empty($end_city_id) || empty($end_lat) || empty($end_lng)) { // || empty($end_location)
            $this->app_error_func(996, '终点地址无效');
            exit;
        }

        $this->common_model->trans_begin();

        // 是否是第一次发车
        // $where = array(
        //     'driver_id' => $this->data['driver_id'],
        //     'order_type' => 5,
        // );
        // $history_order_data_list = $this->orders_service->get_orders_data($where);
        // if (empty($history_order_data_list)) {
        //     // 增加积分
        //     $rtn = $this->driver_service->update_driver_score($this->data['driver_id'], 1);
        //     if ($rtn === FALSE) {
        //         $this->app_error_func(666, '积分增加失败');
        //         exit;
        //     }
        //     $this->data['error']['body'] = $rtn;
        // }

        $time = time();

        // 货主信息
        $shipper_data = $this->shipper_service->get_shipper_by_id($shipper_id);

        // 起点市信息
        $start_city_data = $this->region_service->get_region_by_id($start_city_id);
        if ($start_city_data['level'] != 2) {
            $this->common_model->trans_rollback();

            $this->app_error_func(110, 'start_city_id 参数错误');
            exit;
        }

        $start_province_data = $this->region_service->get_region_by_id($start_city_data['parent_id']);
        if ($start_province_data['region_name'] == $start_city_data['region_name']) {
            $start_province_data['region_name'] = '';
        }
        // 终点市信息
        $end_city_data = $this->region_service->get_region_by_id($end_city_id);
        if ($end_city_data['level'] != 2) {
            $this->common_model->trans_rollback();
            
            $this->app_error_func(120, 'end_city_id 参数错误');
            exit;
        }

        $end_province_data = $this->region_service->get_region_by_id($end_city_data['parent_id']);
        if ($end_province_data['region_name'] == $end_city_data['region_name']) {
            $end_province_data['region_name'] = '';
        }

        // 线路信息
        $where = array(
            'start_city_id' => $start_city_id,
            'end_city_id' => $end_city_id,
        );
        $route_data = $this->route_service->get_route_data($where);
        $order_start_city = $start_province_data['region_name'].$start_city_data['region_name'];
        $order_end_city = $end_province_data['region_name'].$end_city_data['region_name'];

        // 线路信息
        $good_load_time = $time;
        $good_start_time = $time;
        $good_end_time = $good_start_time + $route_data['route_duration'];
        $good_unload_time = $good_end_time;

        // 装卸货地点经纬度
        $start_location_lat = $start_lat;
        $start_location_lng = $start_lng;
        $end_location_lat = $end_lat;
        $end_location_lng = $end_lng;

        // 货运公司专线信息
        $where = array(
            'shipper_company_id' => $shipper_data['company_id'],
            'route_id' => $route_data['route_id'],
        );

        // 先验证线路是否存在，不存在则新建线路，新建专线公司关联线路
        $shipper_route_data = $this->shipper_route_service->get_shipper_route_data($where);
        if (empty($shipper_route_data)) {
            $where = array(
                'start_province_id' => $start_province_data['id'],
                'start_city_id' => $start_city_data['id'],
                'end_province_id' => $end_province_data['id'],
                'end_city_id' => $end_city_data['id'],
            );
            $route_data = $this->route_service->get_route_data($where);
            if (empty($route_data)) {
                $data = array(
                    'start_province_id' => $start_province_data['id'],
                    'start_city_id' => $start_city_data['id'],
                    'end_province_id' => $end_province_data['id'],
                    'end_city_id' => $end_city_data['id'],
                    'route_time' => date('Y-m-d H:i:s', $time),
                    'route_name' => $start_province_data['region_name'].$start_city_data['region_name'].'-'.$end_province_data['region_name'].$end_city_data['region_name'],
                    'route_duration' => 6 * 3600,   // 默认6小时
                );
                $insert_route_id = $this->common_model->insert('route', $data);
            } else {
                $insert_route_id = $route_data['route_id'];
            }

            $data = array(
                'shipper_company_id' => $shipper_data['company_id'],
                'route_id' => $insert_route_id,
                'shipper_company_tel' => '',
                'shipper_route_freight' => 0,
                'shipper_route_margin' => 0,
                'create_time' => date('Y-m-d H:i:s', $time),
            );
            $insert_shipper_route_id = $this->common_model->insert('shipper_route', $data);
        }

        // 重新查询
        $where = array(
            'shipper_company_id' => $shipper_data['company_id'],
            'route_id' => $route_data['route_id'],
        );
        $shipper_route_data = $this->shipper_route_service->get_shipper_route_data($where);

        // 车辆所属司机信息
        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        $vehicle_data = $this->vehicle_service->get_vehicle_data($where);

        $order_num = get_order_sn($shipper_id);

        $data = array(
            'shipper_id' => $shipper_id,
            'good_name' => '公版APP订单',
            'good_category' => 3,   // 默认泡货
            'install_require_id' => 1, // 默认两装两卸
            'is_overranging_id' => 1,   // 默认未超限
            'vehicle_type' => 1,    // 默认平板
            'start_province_id' => $start_province_data['id'],
            'start_city_id' => $start_city_data['id'],
            'end_province_id' => $end_province_data['id'],
            'end_city_id' => $end_city_data['id'],
            'order_start_city' => $order_start_city,
            'order_end_city' => $order_end_city,
            'good_load_addr' => '', // $start_location
            'good_load_time' => $good_load_time,
            'good_start_time' => $good_start_time,
            'good_end_time' => $good_end_time,
            'order_validity' => 24, // 有效期，默认24
            'order_overdue' => $time + 24 * 3600,   // 失效时间，创建时间 + 有效期
            'good_unload_addr' => '', // $end_location
            'good_unload_time' => $good_unload_time,
            'good_freight' => !empty($shipper_route_data['shipper_route_freight']) ? $shipper_route_data['shipper_route_freight'] : 0,
            'good_margin' => !empty($shipper_route_data['shipper_route_margin']) ? $shipper_route_data['shipper_route_margin'] : 0,
            'good_mobile' => $this->data['driver_data']['driver_mobile'],
            'good_contact' => $end_location,
            'good_volume' => 100,   // 默认100立方
            'good_load' => 35,  // 默认35吨
            'good_nums' => 1,   // 默认1
            'order_status' => 1,
            'release_id' => $shipper_id,
            'order_type' => 4,
            'create_time' => $time,
            'driver_id' => $this->data['driver_id'],
            'vehicle_id' => $vehicle_data['vehicle_id'],
            'order_num' => $order_num,
            'is_view_draft' => 2,
            'start_location_lat' => $start_location_lat,
            'start_location_lng' => $start_location_lng,
            'end_location_lat' => $end_location_lat,
            'end_location_lng' => $end_location_lng,
            'cre_from' => 2,
        );
        $order_id = $this->common_model->insert('orders', $data);

        if (empty($order_id)) {
            $this->common_model->trans_rollback();

            $this->app_error_func(994, '操作失败');
            exit;
        }

        // 写入 order_log 日志
        for ($i=2; $i <= 4; $i++) {
            if ($i == 2) {
                $des = '公版APP - 待接';
            } elseif ($i == 3) {
                $des = '公版APP - 已接';
            } elseif ($i == 4) {
                $des = '公版APP - 发车';
            }

            $where = array(
                'order_id' => $order_id,
                'driver_id' => $this->data['driver_id'],
                'vehicle_id' => $vehicle_data['vehicle_id'],
                'order_type' => $i,
            );
            $order_log_data = $this->order_log_service->get_order_log_data($where);
            if (empty($order_log_data)) {
                $data = array(
                    'order_id' => $order_id,
                    'driver_id' => $this->data['driver_id'],
                    'vehicle_id' => $vehicle_data['vehicle_id'],
                    'order_type' => $i,
                    'opereation_id' => $this->data['driver_id'],
                    'create_time' => date('Y-m-d H:i:s', $time + ($i - 1)),
                    'des' => $des,
                );
                $this->common_model->insert('order_log', $data);
            }
        }

        // 司机选择城市记录
        // 起点
        $where = array(
            'select_type' => 1,
            'driver_id' => $this->data['driver_id'],
            'city_id' => $start_city_id,
        );
        $driver_history_region_data = $this->driver_history_region_service->get_data($where);
        if (empty($driver_history_region_data)) {
            $data = array(
                'select_type' => 1,
                'driver_id' => $this->data['driver_id'],
                'city_id' => $start_city_id,
                'select_count' => 1,
                'cretime' => time(),
            );
            $this->common_model->insert('driver_history_region', $data);
        } else {
            $this->db->set('select_count', 'select_count + 1', FALSE)->where($where)->update('driver_history_region');
        }
        // 终点
        $where = array(
            'select_type' => 2,
            'driver_id' => $this->data['driver_id'],
            'city_id' => $end_city_id,
        );
        $driver_history_region_data = $this->driver_history_region_service->get_data($where);
        if (empty($driver_history_region_data)) {
            $data = array(
                'select_type' => 2,
                'driver_id' => $this->data['driver_id'],
                'city_id' => $end_city_id,
                'select_count' => 1,
                'cretime' => time(),
            );
            $this->common_model->insert('driver_history_region', $data);
        } else {
            $this->db->set('select_count', 'select_count + 1', FALSE)->where($where)->update('driver_history_region');
        }

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }

    public function index()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $per_page = 8;    // 每页显示数量
        $cur_page = $this->input->get_post('cur_page') ? $this->input->get_post('cur_page') : 1;    // 当前页
        $cur_num = ($cur_page - 1) * $per_page;

        $where = array(
            'driver_id' => $this->data['driver_id'],
            'order_type' => 5,
        );

        // 总数
        $data_list = $this->orders_service->get_orders_data_list($where);
        $total = count($data_list);
        $this->data['error']['body']['total'] = $total;

        $this->data['error']['body']['data_list'] = array();
        $data_list = $this->orders_service->get_orders_data_list($where, $per_page, $cur_num, 'order_id', 'DESC');
        if ($data_list) {
            foreach ($data_list as $value) {
                $this->data['error']['body']['data_list'][] = array(
                    'order_id' => $value['order_id'],
                    'start_location' => $value['order_start_city'].$value['good_load_addr'],
                    'end_location' => $value['order_end_city'].$value['good_unload_addr'],
                    'end_time' => !empty($value['order_end_time']) ? date('Y年m月d日 H时i分', $value['order_end_time']) : '',
                );
            }
        }

        echo json_en($this->data['error']);
        exit;
    }

    public function detail()
    {
        $order_id = $this->input->get_post('order_id', TRUE);

        if (!(is_numeric($order_id) && $order_id > 0)) {
            $this->app_error_func(998, 'order_id 参数错误');
            exit;
        }

        $track_data = $this->orders_service->get_track_by_id($order_id);

        $this->data['error']['body']['data_list'] = $track_data;

        echo json_en($this->data['error']);
        exit;
    }

    public function finished_order()
    {
        $order_id = $this->input->get_post('order_id', TRUE);

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (!(is_numeric($order_id) && $order_id > 0)) {
            $this->app_error_func(997, 'order_id 参数错误');
            exit;
        }

        $where = array(
            'order_id' => $order_id,
            'driver_id' => $this->data['driver_id'],
        );
        $order_data = $this->orders_service->get_orders_data($where);
        if (count($order_data) == 0) {
            $this->app_error_func(996, '记录不存在');
            exit;
        }

        $time = time();

        if ($time < ($order_data['good_start_time'] + 4 * 3600)) {
            $this->app_error_func(888, '运单未达到完成条件');
            exit;
        }

        $this->common_model->trans_begin();

        $data = array(
            'order_end_time' => $time + 3600,
            'order_type' => 5,
        );
        $where = array(
            'order_id' => $order_data['order_id'],
        );
        $this->common_model->update('orders', $data, $where);

        // 写入 order_log 日志
        $data = array(
            'order_id' => $order_id,
            'driver_id' => $order_data['driver_id'],
            'vehicle_id' => $order_data['vehicle_id'],
            'order_type' => 5,
            'opereation_id' => $order_data['driver_id'],
            'create_time' => date('Y-m-d H:i:s', $time + 60),
            'des' => '公版APP - 完成',
        );
        $this->common_model->insert('order_log', $data);

        // 增加积分 - 司机是否是第一单
        $this->shipper_company_service->driver_first_finished_order($this->data['driver_id'], $order_id);

        // 增加积分
        $rtn = $this->driver_service->update_driver_score($this->data['driver_id'], 2);
        if ($rtn === FALSE) {
            $this->app_error_func(666, '积分增加失败');
            exit;
        }
        $this->data['error']['body'] = $rtn;

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }

    public function deleted_order()
    {
        $order_id = $this->input->get_post('order_id', TRUE);

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (!(is_numeric($order_id) && $order_id > 0)) {
            $this->app_error_func(997, 'order_id 参数错误');
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        $where = array(
            'order_id' => $order_id,
            'driver_id' => $this->data['driver_id'],
        );
        $order_data = $this->orders_service->get_orders_data($where);
        if (count($order_data) == 0) {
            $this->app_error_func(996, '记录不存在');
            exit;
        }

        $time = time();

        $data = array(
            'order_type' => 6,
        );
        $where = array(
            'order_id' => $order_data['order_id'],
        );
        $this->common_model->update('orders', $data, $where);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }
}