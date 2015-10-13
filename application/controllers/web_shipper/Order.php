<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

    public function ajax_get_order_detail()
    {
        $error = array(
            'code' => 'success',
            'order_detail_data' => array(),
        );

        $this->data['order_id'] = $this->input->post('order_id', TRUE);

        if (!(is_numeric($this->data['order_id']) && $this->data['order_id'] > 0)) {
            $error['code'] = 'order_id 参数错误';
            echo json_encode($error);
            exit;
        }

        $order_data = $this->orders_service->get_orders_by_id($this->data['order_id']);
        $goods_category = $this->goods_category_service->get_goods_category_by_id($order_data['good_category']);
        $install_require = $this->config->item('install_require');

        $start_province_data = $this->region_service->get_region_by_id($order_data['start_province_id']);
        $start_city_data = $this->region_service->get_region_by_id($order_data['start_city_id']);
        if ($start_province_data['region_name'] == $start_city_data['region_name']) {
            $start_city_data['region_name'] = '';
        }
        $start_location = $start_province_data['region_name'].$start_city_data['region_name'];

        $end_province_data = $this->region_service->get_region_by_id($order_data['end_province_id']);
        $end_city_data = $this->region_service->get_region_by_id($order_data['end_city_id']);
        if ($end_province_data['region_name'] == $end_city_data['region_name']) {
            $end_city_data['region_name'] = '';
        }
        $end_location = $end_province_data['region_name'].$end_city_data['region_name'];

        $driver_data = $this->driver_service->get_driver_by_id($order_data['driver_id']);

        $where = array(
            'driver_id' => $order_data['driver_id'],
            'vehicle_id' => $order_data['vehicle_id'],
        );
        $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
        $latitude = $tracking_data['latitude'] ? $tracking_data['latitude'] : '121.470156';
        $longitude = $tracking_data['longitude'] ? $tracking_data['longitude'] : '31.24255';
        $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
        $current_location = $current_location.' '.($tracking_data['create_time'] ? date('H:i', strtotime($tracking_data['create_time'])) : '');

        $vehicle_data = $this->vehicle_service->get_vehicle_by_id($order_data['vehicle_id']);
        $vehicle_type_data = $this->vehicle_service->get_vehicle_type_by_id($vehicle_data['vehicle_type']);

        $error['order_detail_data']['detail_good_name'] = $order_data['good_name'];
        $error['order_detail_data']['detail_good_mobile'] = $order_data['good_mobile'];
        $error['order_detail_data']['detail_good_category'] = $goods_category['catname'];
        $error['order_detail_data']['detail_good_load_time'] = date('Y-m-d H:i:s', $order_data['good_load_time']);
        $error['order_detail_data']['detail_install_require_id'] = $install_require[$order_data['install_require_id']]['name'];
        $error['order_detail_data']['detail_good_nums'] = $order_data['good_nums'];
        $error['order_detail_data']['detail_good_load'] = $order_data['good_load'];
        $error['order_detail_data']['detail_good_load_addr'] = $order_data['good_load_addr'];
        $error['order_detail_data']['detail_good_volume'] = $order_data['good_volume'];
        $error['order_detail_data']['detail_good_start_time'] = date('Y-m-d H:i:s', $order_data['good_start_time']);
        $error['order_detail_data']['detail_start_location'] = $start_location;
        $error['order_detail_data']['detail_good_contact'] = $order_data['good_contact'];
        $error['order_detail_data']['detail_end_location'] = $end_location;
        $error['order_detail_data']['detail_good_unload_time'] = date('Y-m-d H:i:s', $order_data['good_unload_time']);
        $error['order_detail_data']['detail_good_freight'] = $order_data['good_freight'];
        $error['order_detail_data']['detail_good_unload_addr'] = $order_data['good_unload_addr'];
        $error['order_detail_data']['detail_good_margin'] = $order_data['good_margin'];
        $error['order_detail_data']['detail_order_num'] = $order_data['order_num'];
        $error['order_detail_data']['detail_driver_name'] = $driver_data['driver_name'];
        $error['order_detail_data']['detail_driver_mobile'] = $driver_data['driver_mobile'];
        $error['order_detail_data']['detail_current_location'] = $current_location;
        $error['order_detail_data']['detail_vehicle_card_num'] = $vehicle_data['vehicle_card_num'];
        $error['order_detail_data']['detail_vehicle_type'] = $vehicle_type_data['type_name'];
        $error['order_detail_data']['detail_vehicle_length'] = $vehicle_data['vehicle_length'];
        $error['order_detail_data']['latitude'] = $latitude;
        $error['order_detail_data']['longitude'] = $longitude;
        $error['order_detail_data']['start_city_id'] = $order_data['start_city_id'];
        $error['order_detail_data']['end_city_id'] = $order_data['end_city_id'];
        $error['order_detail_data']['route_id'] = $order_data['order_start_city'].'-'.$order_data['order_end_city'];
        $error['order_detail_data']['vehicle_id'] = $order_data['vehicle_id'];

        $error['track_data'] = $this->order_track_data();

        echo json_encode($error);
        exit;
    }

    public function order_track_data()
    {
        $track_data = array(
            'track_st' => array(),
            'track_log' => array(),
        );

        $where = array(
            'order_id' => $this->data['order_id'],
        );
        $data_list = $this->order_log_service->get_order_log_data_list($where);
        $track_data['track_st']['st_1'] = $track_data['track_st']['st_2'] = $track_data['track_st']['st_3'] = $track_data['track_st']['st_4'] = $track_data['track_st']['st_5'] = 0;
        if ($data_list) {
            foreach ($data_list as $key => $value) {
                if ($value['order_type'] == 3) {
                    $track_data['track_st']['st_1'] = 1;
                    $track_data['track_log'][] = array(
                        'track_desc' => '已经接单',
                        'track_time' => date('Y年m月d日 H时i分', strtotime($value['create_time'])),
                    );
                }
                if ($value['order_type'] == 4) {
                    $track_data['track_st']['st_2'] = $track_data['track_st']['st_3'] = 1;

                    // 检查是否有异常数据
                    $where = array(
                        'order_id' => $this->data['order_id'],
                    );
                    $driver_anomaly_data_list = $this->driver_anomaly_service->get_driver_anomaly_data_list($where);
                    $driver_anomaly = array();
                    if ($driver_anomaly_data_list) {
                        foreach ($driver_anomaly_data_list as $value2) {
                            $where = array(
                                'driver_anomaly_id' => $value2['id'],
                            );
                            $driver_anomaly_attachment_data_list = $this->driver_anomaly_service->get_driver_anomaly_attachment_data_list($where);

                            $driver_anomaly_img_list = array();
                            if ($driver_anomaly_attachment_data_list) {
                                foreach ($driver_anomaly_attachment_data_list as $value3) {
                                    $attachment_data = $this->attachment_service->get_attachment_by_id($value3['attachment_id']);
                                    $driver_anomaly_img_list[] = $attachment_data['http_file'];
                                }
                            }

                            $driver_anomaly[] = array(
                                'exce_desc' => $value2['exce_desc'],
                                'province_name' => $value2['province_name'],
                                'city_name' => $value2['city_name'],
                                'speedInKPH' => $value2['speedInKPH'],
                                'heading' => $value2['heading'],
                                'cretime' => date('Y年m月d日 H时i分', $value2['cretime']),
                                'driver_anomaly_img_list' => $driver_anomaly_img_list,
                            );
                        }
                    }

                    $track_data['track_log'][] = array(
                        'track_desc' => '已经发车',
                        'track_time' => date('Y年m月d日 H时i分', strtotime($value['create_time'])),
                        'driver_anomaly' => $driver_anomaly,
                    );
                }
                if ($value['order_type'] == 5) {
                    $track_data['track_st']['st_4'] = $track_data['track_st']['st_5'] = 1;
                    $track_data['track_log'][] = array(
                        'track_desc' => '运单完成',
                        'track_time' => date('Y年m月d日 H时i分', strtotime($value['create_time'])),
                    );
                }
            }
        }

        return $track_data;
    }

    public function ajax_edit_special_order()
    {
        $error = array(
            'code' => 'success',
        );

        $order_id = $this->input->post('order_id', TRUE);

        if (!(is_numeric($order_id) && $order_id > 0)) {
            $error['code'] = 'order_id 参数错误';
            echo json_encode($error);
            exit;
        }

        $order_type = $this->input->post('order_type', TRUE);
        $good_name = trim($this->input->post('good_name', TRUE));
        $good_load_time = $this->input->post('good_load_time', TRUE);
        $route_id = $this->input->post('route_id', TRUE);
        $good_load_addr = trim($this->input->post('good_load_addr', TRUE));
        $good_mobile = trim($this->input->post('good_mobile', TRUE));
        $good_start_time = $this->input->post('good_start_time', TRUE);
        $good_contact = trim($this->input->post('good_contact', TRUE));
        $good_unload_time = $this->input->post('good_unload_time', TRUE);
        $vehicle_id = $this->input->post('vehicle_id', TRUE);
        $good_unload_addr = trim($this->input->post('good_unload_addr', TRUE));
        $order_num = get_order_sn($this->shipper_info['shipper_id']);

        if (empty($good_name) || $good_name == '请输入货物名称') {
            $error['code'] = '请输入货物名称';
            echo json_encode($error);
            exit;
        }

        if (empty($good_mobile) || $good_mobile == '请输入发货人') {
            $error['code'] = '请输入发货人';
            echo json_encode($error);
            exit;
        }

        if (empty($good_contact) || $good_contact == '请输入收货人') {
            $error['code'] = '请输入收货人';
            echo json_encode($error);
            exit;
        }

        if (empty($good_load_time) || $good_load_time == '请选择装货时间') {
            $error['code'] = '请选择装货时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_load_addr) || $good_load_addr == '请输入装货地点') {
            $error['code'] = '请输入装货地点';
            echo json_encode($error);
            exit;
        }

        if (empty($good_start_time) || $good_start_time == '请选择发车时间') {
            $error['code'] = '请选择发车时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_unload_time) || $good_unload_time == '请选择卸货时间') {
            $error['code'] = '请选择卸货时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_unload_addr) || $good_unload_addr == '请输入卸货地点') {
            $error['code'] = '请输入卸货地点';
            echo json_encode($error);
            exit;
        }

        // 线路信息
        $route_data = $this->route_service->get_route_by_id($route_id);
        $array = explode("-", $route_data['route_name']);
        $order_start_city = $array[0];
        $order_end_city = $array[1];
        $good_load_time = strtotime($good_load_time);
        $good_start_time = strtotime($good_start_time);
        $good_end_time = $good_start_time + $route_data['route_duration'];
        $good_unload_time = strtotime($good_unload_time);

        // 货运公司专线信息
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
            'route_id' => $route_id,
        );
        $shipper_route_data = $this->shipper_route_service->get_shipper_route_data($where);

        // 车辆所属司机信息
        $vehicle_data = $this->vehicle_service->get_vehicle_by_id($vehicle_id);

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'shipper_id' => $this->shipper_info['shipper_id'],
            'good_name' => $good_name,
            'good_category' => 3,   // 默认泡货
            'install_require_id' => 1, // 默认两装两卸
            'is_overranging_id' => 1,   // 默认未超限
            'vehicle_type' => 1,    // 默认平板
            'start_province_id' => $route_data['start_province_id'],
            'start_city_id' => $route_data['start_city_id'],
            'end_province_id' => $route_data['end_province_id'],
            'end_city_id' => $route_data['end_city_id'],
            'order_start_city' => $order_start_city,
            'order_end_city' => $order_end_city,
            'good_load_addr' => $good_load_addr,
            'good_load_time' => $good_load_time,
            'good_start_time' => $good_start_time,
            'good_end_time' => $good_end_time,
            'order_validity' => 24, // 有效期，默认24
            'order_overdue' => $time + 24 * 3600,   // 失效时间，创建时间 + 有效期
            'good_unload_addr' => $good_unload_addr,
            'good_unload_time' => $good_unload_time,
            'good_freight' => $shipper_route_data['shipper_route_freight'],
            'good_margin' => $shipper_route_data['shipper_route_margin'],
            'good_mobile' => $good_mobile,
            'good_contact' => $good_contact,
            'good_volume' => 100,   // 默认100立方
            'good_load' => 35,  // 默认35吨
            'good_nums' => 1,   // 默认1
            'order_status' => 1,
            'release_id' => $this->shipper_info['shipper_id'],
            'order_type' => $order_type,
            'driver_id' => $vehicle_data['driver_id'],
            'vehicle_id' => $vehicle_id,
            'order_num' => $order_num,
        );
        $where = array(
            'order_id' => $order_id,
        );

        $order_id = $this->common_model->update('orders', $data, $where);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = '操作失败，请重新操作！';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }

    public function search_common()
    {
        // 货运公司货车数
        $this->data['shipper_driver_count_data'] = $this->shipper_driver_service->get_shipper_driver_count($this->shipper_info);

        $this->data['k'] = $this->input->get('k', TRUE);
        $this->data['k'] = $this->data['k'] == '请输入司机名称' ? '' : $this->data['k'];

        $this->data['search_str'] = '?1';
        if (!empty($this->data['k'])) {
            $this->data['search_str'] .= '&k='.$this->data['k'];

            $where = array(
                'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
                'driver_name LIKE' => '%'.$this->data['k'].'%',
            );
            $this->data['search_driver_data_list'] = $this->driver_service->get_driver_data_list($where);
            $this->data['search_driver_ids'] = array();
            $this->data['search_vehicle_ids'] = array();
            if ($this->data['search_driver_data_list']) {
                foreach ($this->data['search_driver_data_list'] as $value) {
                    $this->data['search_driver_ids'][$value['driver_id']] = $value['driver_id'];

                    $where = array(
                        'driver_id' => $value['driver_id'],
                    );
                    $vehicle_data = $this->vehicle_service->get_vehicle_data($where);
                    $this->data['search_vehicle_ids'][$vehicle_data['vehicle_id']] = $vehicle_data['vehicle_id'];
                }
            }
            $this->data['shipper_driver_count_data']['driver_ids'] = $this->data['search_driver_ids'];
            $this->data['shipper_driver_count_data']['vehicle_ids'] = $this->data['search_vehicle_ids'];
        }
    }

    public function index()
    {
        $this->data['title'] = '运单首页';

        $this->load->view($this->appfolder.'/order/order_view', $this->data);
    }

    public function publish_order()
    {
        $this->data['title'] = '新建运单';

        // 货主公司信息
        $shipper_company_data = $this->shipper_company_service->get_shipper_company_by_id($this->shipper_info['company_id']);

        // 专线货主
        if ($shipper_company_data['is_special'] == 1) {
            $this->special_handle();
        // 一般货主
        } elseif ($shipper_company_data['is_special'] == 2) {
            $this->normal_hanlde();
        }
    }

    public function special_handle()
    {
        // 货运线路
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_shipper_route_options'] = $this->shipper_route_service->get_shipper_route_options($where);

        // 指定货车
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_current_shipper_driver_vehicle_options'] = $this->vehicle_service->get_current_shipper_driver_vehicle_options(0, $where);

        $this->load->view($this->appfolder.'/order/publish_special_order_view', $this->data);
    }

    public function ajax_get_route_data()
    {
        $error = array(
            'code' => 'success',
        );

        $route_id = $this->input->post('route_id', TRUE);

        $route_data = $this->route_service->get_route_by_id($route_id);
        $error['start_city_id'] = $route_data['start_city_id'];
        $error['end_city_id'] = $route_data['end_city_id'];

        echo json_encode($error);
        exit;
    }

    public function ajax_do_special_order()
    {
        $error = array(
            'code' => 'success',
        );

        $order_type = $this->input->post('order_type', TRUE);
        $good_name = trim($this->input->post('good_name', TRUE));
        $good_load_time = $this->input->post('good_load_time', TRUE);
        $route_id = $this->input->post('route_id', TRUE);
        $good_load_addr = trim($this->input->post('good_load_addr', TRUE));
        $good_mobile = trim($this->input->post('good_mobile', TRUE));
        $good_start_time = $this->input->post('good_start_time', TRUE);
        $good_contact = trim($this->input->post('good_contact', TRUE));
        $good_unload_time = $this->input->post('good_unload_time', TRUE);

        $good_load_addr = trim($this->input->post('good_load_addr', TRUE));
        $good_load_addr_lat_lng = trim($this->input->post('good_load_addr_lat_lng', TRUE));
        $good_load_addr_lat_lng = json_decode($good_load_addr_lat_lng, TRUE);

        $good_unload_addr = trim($this->input->post('good_unload_addr', TRUE));
        $good_unload_addr_lat_lng = trim($this->input->post('good_unload_addr_lat_lng', TRUE));
        $good_unload_addr_lat_lng = json_decode($good_unload_addr_lat_lng, TRUE);

        $vehicle_id = $this->input->post('vehicle_id', TRUE);
        $good_unload_addr = trim($this->input->post('good_unload_addr', TRUE));
        $order_num = get_order_sn($this->shipper_info['shipper_id']);

        if (empty($good_name) || $good_name == '请输入货物名称') {
            $error['code'] = '请输入货物名称';
            echo json_encode($error);
            exit;
        }

        if (empty($good_mobile) || $good_mobile == '请输入发货人') {
            $error['code'] = '请输入发货人';
            echo json_encode($error);
            exit;
        }

        if (empty($good_contact) || $good_contact == '请输入收货人') {
            $error['code'] = '请输入收货人';
            echo json_encode($error);
            exit;
        }

        if (empty($good_load_time) || $good_load_time == '请选择装货时间') {
            $error['code'] = '请选择装货时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_load_addr) || $good_load_addr == '请输入装货地点') {
            $error['code'] = '请输入装货地点';
            echo json_encode($error);
            exit;
        }

        if (empty($good_load_addr_lat_lng)) {
            $error['code'] = '装货地点无效，请重新输入';
            echo json_encode($error);
            exit;
        }

        if (empty($good_start_time) || $good_start_time == '请选择发车时间') {
            $error['code'] = '请选择发车时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_unload_time) || $good_unload_time == '请选择卸货时间') {
            $error['code'] = '请选择卸货时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_unload_addr) || $good_unload_addr == '请输入卸货地点') {
            $error['code'] = '请输入卸货地点';
            echo json_encode($error);
            exit;
        }

        if (empty($good_unload_addr_lat_lng)) {
            $error['code'] = '卸货地点无效，请重新输入';
            echo json_encode($error);
            exit;
        }

        // 线路信息
        $route_data = $this->route_service->get_route_by_id($route_id);
        $array = explode("-", $route_data['route_name']);
        $order_start_city = $array[0];
        $order_end_city = $array[1];
        $good_load_time = strtotime($good_load_time);
        $good_start_time = strtotime($good_start_time);
        $good_end_time = $good_start_time + $route_data['route_duration'];
        $good_unload_time = strtotime($good_unload_time);

        // 装卸货地点经纬度
        $start_location_lat = $good_load_addr_lat_lng['lat'];
        $start_location_lng = $good_load_addr_lat_lng['lng'];
        $end_location_lat = $good_unload_addr_lat_lng['lat'];
        $end_location_lng = $good_unload_addr_lat_lng['lng'];

        // 货运公司专线信息
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
            'route_id' => $route_id,
        );
        $shipper_route_data = $this->shipper_route_service->get_shipper_route_data($where);

        // 车辆所属司机信息
        $vehicle_data = $this->vehicle_service->get_vehicle_by_id($vehicle_id);

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'shipper_id' => $this->shipper_info['shipper_id'],
            'good_name' => $good_name,
            'good_category' => 3,   // 默认泡货
            'install_require_id' => 1, // 默认两装两卸
            'is_overranging_id' => 1,   // 默认未超限
            'vehicle_type' => 1,    // 默认平板
            'start_province_id' => $route_data['start_province_id'],
            'start_city_id' => $route_data['start_city_id'],
            'end_province_id' => $route_data['end_province_id'],
            'end_city_id' => $route_data['end_city_id'],
            'order_start_city' => $order_start_city,
            'order_end_city' => $order_end_city,
            'good_load_addr' => $good_load_addr,
            'good_load_time' => $good_load_time,
            'good_start_time' => $good_start_time,
            'good_end_time' => $good_end_time,
            'order_validity' => 24, // 有效期，默认24
            'order_overdue' => $time + 24 * 3600,   // 失效时间，创建时间 + 有效期
            'good_unload_addr' => $good_unload_addr,
            'good_unload_time' => $good_unload_time,
            'good_freight' => $shipper_route_data['shipper_route_freight'],
            'good_margin' => $shipper_route_data['shipper_route_margin'],
            'good_mobile' => $good_mobile,
            'good_contact' => $good_contact,
            'good_volume' => 100,   // 默认100立方
            'good_load' => 35,  // 默认35吨
            'good_nums' => 1,   // 默认1
            'order_status' => 1,
            'release_id' => $this->shipper_info['shipper_id'],
            'order_type' => $order_type,
            'create_time' => $time,
            'driver_id' => $vehicle_data['driver_id'],
            'vehicle_id' => $vehicle_id,
            'order_num' => $order_num,
            'start_location_lat' => $start_location_lat,
            'start_location_lng' => $start_location_lng,
            'end_location_lat' => $end_location_lat,
            'end_location_lng' => $end_location_lng,
        );

        $order_id = $this->common_model->insert('orders', $data);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = '操作失败，请重新操作！';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }

    public function normal_hanlde()
    {
        // 货物类型
        $this->data['get_goods_category_options'] = $this->goods_category_service->get_goods_category_options();

        // 指定货车
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_current_shipper_driver_vehicle_options'] = $this->vehicle_service->get_current_shipper_driver_vehicle_options(0, $where);

        // 出发地省份
        $where = array(
            'parent_id' => 1,
        );
        $this->data['get_region_options'] = $this->region_service->get_region_options(0, $where);

        $this->load->view($this->appfolder.'/order/publish_normal_order_view', $this->data);
    }

    public function ajax_do_normal_order()
    {
        $error = array(
            'code' => 'success',
        );

        $order_type = $this->input->post('order_type', TRUE);
        $good_name = trim($this->input->post('good_name', TRUE));
        $good_category = $this->input->post('good_category', TRUE);
        $good_load_time = $this->input->post('good_load_time', TRUE);
        $good_mobile = trim($this->input->post('good_mobile', TRUE));
        $good_start_time = $this->input->post('good_start_time', TRUE);
        $good_contact = trim($this->input->post('good_contact', TRUE));
        $good_unload_time = $this->input->post('good_unload_time', TRUE);
        $vehicle_id = $this->input->post('vehicle_id', TRUE);
        $good_nums = trim($this->input->post('good_nums', TRUE));
        $good_load = trim($this->input->post('good_load', TRUE));
        $install_require_id = $this->input->post('install_require_id', TRUE);
        $good_volume = trim($this->input->post('good_volume', TRUE));
        $is_overranging_id = $this->input->post('is_overranging_id', TRUE);
        $good_freight = trim($this->input->post('good_freight', TRUE));
        $good_margin = trim($this->input->post('good_margin', TRUE));

        $good_load_addr = trim($this->input->post('good_load_addr', TRUE));
        $good_load_addr_lat_lng = trim($this->input->post('good_load_addr_lat_lng', TRUE));
        $good_load_addr_lat_lng = json_decode($good_load_addr_lat_lng, TRUE);

        $good_unload_addr = trim($this->input->post('good_unload_addr', TRUE));
        $good_unload_addr_lat_lng = trim($this->input->post('good_unload_addr_lat_lng', TRUE));
        $good_unload_addr_lat_lng = json_decode($good_unload_addr_lat_lng, TRUE);

        $start_province_id = $this->input->post('start_province_id', TRUE);
        $start_city_id = $this->input->post('start_city_id', TRUE);
        $end_province_id = $this->input->post('end_province_id', TRUE);
        $end_city_id = $this->input->post('end_city_id', TRUE);

        $order_num = get_order_sn($this->shipper_info['shipper_id']);

        if (empty($good_name) || $good_name == '请输入货物名称') {
            $error['code'] = '请输入货物名称';
            echo json_encode($error);
            exit;
        }

        if (empty($good_mobile) || $good_mobile == '请输入发货人') {
            $error['code'] = '请输入发货人';
            echo json_encode($error);
            exit;
        }

        if (empty($good_contact) || $good_contact == '请输入收货人') {
            $error['code'] = '请输入收货人';
            echo json_encode($error);
            exit;
        }

        if (empty($good_load_time) || $good_load_time == '请选择装货时间') {
            $error['code'] = '请选择装货时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_load_addr) || $good_load_addr == '请输入装货地点') {
            $error['code'] = '请输入装货地点';
            echo json_encode($error);
            exit;
        }

        if (empty($good_load_addr_lat_lng)) {
            $error['code'] = '装货地点无效，请重新输入';
            echo json_encode($error);
            exit;
        }

        if (empty($good_start_time) || $good_start_time == '请选择发车时间') {
            $error['code'] = '请选择发车时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_unload_time) || $good_unload_time == '请选择卸货时间') {
            $error['code'] = '请选择卸货时间';
            echo json_encode($error);
            exit;
        }

        if (empty($good_unload_addr) || $good_unload_addr == '请输入卸货地点') {
            $error['code'] = '请输入卸货地点';
            echo json_encode($error);
            exit;
        }

        if (empty($good_unload_addr_lat_lng)) {
            $error['code'] = '卸货地点无效，请重新输入';
            echo json_encode($error);
            exit;
        }

        if (!(is_numeric($good_nums) && $good_nums > 0)) {
            $error['code'] = '请正确填写货物数量，如：3';
            echo json_encode($error);
            exit;
        }

        if (!(is_numeric($good_load) && $good_load > 0)) {
            $error['code'] = '请正确填写货物重量，如：35';
            echo json_encode($error);
            exit;
        }

        if (!(is_numeric($good_volume) && $good_volume > 0)) {
            $error['code'] = '请正确填写货物体积，如：100';
            echo json_encode($error);
            exit;
        }

        if (!(is_numeric($good_freight) && $good_freight > 0)) {
            $error['code'] = '请正确填写运费，如：30000';
            echo json_encode($error);
            exit;
        }

        if (!(is_numeric($good_margin) && $good_margin > 0)) {
            $error['code'] = '请正确填写保证金，如：100000';
            echo json_encode($error);
            exit;
        }

        // 起点市信息
        $start_city_data = $this->region_service->get_region_by_id($start_city_id);
        $start_province_data = $this->region_service->get_region_by_id($start_city_data['parent_id']);
        if ($start_province_data['region_name'] == $start_city_data['region_name']) {
            $start_province_data['region_name'] = '';
        }
        // 终点市信息
        $end_city_data = $this->region_service->get_region_by_id($end_city_id);
        $end_province_data = $this->region_service->get_region_by_id($end_city_data['parent_id']);
        if ($end_province_data['region_name'] == $end_city_data['region_name']) {
            $end_province_data['region_name'] = '';
        }

        // 线路信息
        $where = array(
            'start_city_id' => $start_city_data['id'],
            'end_city_id' => $end_city_data['id'],
        );
        $route_data = $this->route_service->get_route_data($where);
        $order_start_city = $start_province_data['region_name'].$start_city_data['region_name'];
        $order_end_city = $end_province_data['region_name'].$end_city_data['region_name'];
        $good_load_time = strtotime($good_load_time);
        $good_start_time = strtotime($good_start_time);
        $good_end_time = $good_start_time + $route_data['route_duration'];
        $good_unload_time = strtotime($good_unload_time);

        // 装卸货地点经纬度
        $start_location_lat = $good_load_addr_lat_lng['lat'];
        $start_location_lng = $good_load_addr_lat_lng['lng'];
        $end_location_lat = $good_unload_addr_lat_lng['lat'];
        $end_location_lng = $good_unload_addr_lat_lng['lng'];

        // 车辆所属司机信息
        $vehicle_data = $this->vehicle_service->get_vehicle_by_id($vehicle_id);

        // 车辆属性信息
        $vehicle_type_data = $this->vehicle_service->get_vehicle_type_by_id($vehicle_data['vehicle_type']);

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'shipper_id' => $this->shipper_info['shipper_id'],
            'good_name' => $good_name,
            'good_category' => $good_category,
            'install_require_id' => $install_require_id,
            'is_overranging_id' => $is_overranging_id,
            'vehicle_type' => $vehicle_type_data['type_id'],
            'start_province_id' => $start_province_id,
            'start_city_id' => $start_city_id,
            'end_province_id' => $end_province_id,
            'end_city_id' => $end_city_id,
            'order_start_city' => $order_start_city,
            'order_end_city' => $order_end_city,
            'good_load_addr' => $good_load_addr,
            'good_load_time' => $good_load_time,
            'good_start_time' => $good_start_time,
            'good_end_time' => $good_end_time,
            'order_validity' => 24, // 有效期，默认24
            'order_overdue' => $time + 24 * 3600,   // 失效时间，创建时间 + 有效期
            'good_unload_addr' => $good_unload_addr,
            'good_unload_time' => $good_unload_time,
            'good_freight' => $good_freight,
            'good_margin' => $good_margin,
            'good_mobile' => $good_mobile,
            'good_contact' => $good_contact,
            'good_volume' => $good_volume,
            'good_load' => $good_load,
            'good_nums' => $good_nums,
            'order_status' => 1,
            'release_id' => $this->shipper_info['shipper_id'],
            'order_type' => $order_type,
            'create_time' => $time,
            'driver_id' => $vehicle_data['driver_id'],
            'vehicle_id' => $vehicle_id,
            'order_num' => $order_num,
            'start_location_lat' => $start_location_lat,
            'start_location_lng' => $start_location_lng,
            'end_location_lat' => $end_location_lat,
            'end_location_lng' => $end_location_lng,
        );

        $order_id = $this->common_model->insert('orders', $data);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = '操作失败，请重新操作！';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }

    public function ajax_get_region()
    {
        $error = array(
            'code' => 'success'
        );

        $id = $this->input->post('id');
        
        $where = array(
            'parent_id' => $id,
        );
        $data = $this->region_service->get_region_data_list($where);
        
        $error['data'] = $data;
        echo json_encode($error);
        exit;
    }

    public function ajax_start_location_baidumap_place()
    {
        $error = array(
            'code' => 'success'
        );

        $start_city_id = trim($this->input->post('start_city_id', TRUE));
        $q = trim($this->input->post('good_load_addr', TRUE));

        if (!is_numeric($start_city_id) || $start_city_id == 0) {
            $error['code'] = '请选择出发地';
            echo json_encode($error);
            exit;
        }

        if (empty($q)) {
            $error['code'] = '请输入装货地点';
            echo json_encode($error);
            exit;
        }

        $region_data = $this->region_service->get_region_by_id($start_city_id);
        $region = $region_data['region_name'];

        $url = "http://api.map.baidu.com/place/v2/search";
        $params = array(
            'q' => $q,
            'region' => $region,
            'output' => 'json',
            'ak' => BAIDU_AK,
        );
        $response = $this->curl->_simple_call('get', $url, $params);
        $response = json_decode($response, TRUE);
        $results = $response['results'];

        $address_list = array();
        if ($results) {
            foreach ($results as $value) {
                $value['address'] = isset($value['address']) ? $value['address'] : '';

                $address_list[] = array(
                    'location' => json_encode($value['location'], TRUE),
                    'address_detail' => $value['name'],
                    'address' => $value['address'],
                    // 'street_id' => $value['street_id'],
                    // 'telephone' => $value['telephone'],
                    // 'detail' => $value['detail'],
                    // 'uid' => $value['uid'],
                    'address_data' => $value['address'].'（'.$value['name'].'）',
                );
            }
        }

        $error['address_list'] = $address_list;
        echo json_encode($error);
        exit;
    }

    public function ajax_end_location_baidumap_place()
    {
        $error = array(
            'code' => 'success'
        );

        $end_city_id = trim($this->input->post('end_city_id', TRUE));
        $q = trim($this->input->post('good_unload_addr', TRUE));

        if (!is_numeric($end_city_id) || $end_city_id == 0) {
            $error['code'] = '请选择目的地';
            echo json_encode($error);
            exit;
        }

        if (empty($q)) {
            $error['code'] = '请输入卸货地点';
            echo json_encode($error);
            exit;
        }

        $region_data = $this->region_service->get_region_by_id($end_city_id);
        $region = $region_data['region_name'];

        $url = "http://api.map.baidu.com/place/v2/search";
        $params = array(
            'q' => $q,
            'region' => $region,
            'output' => 'json',
            'ak' => BAIDU_AK,
        );
        $response = $this->curl->_simple_call('get', $url, $params);
        $response = json_decode($response, TRUE);
        $results = $response['results'];

        $address_list = array();
        if ($results) {
            foreach ($results as $value) {
                $value['address'] = isset($value['address']) ? $value['address'] : '';
                
                $address_list[] = array(
                    'location' => json_encode($value['location'], TRUE),
                    'address_detail' => $value['name'],
                    'address' => $value['address'],
                    // 'street_id' => $value['street_id'],
                    // 'telephone' => $value['telephone'],
                    // 'detail' => $value['detail'],
                    // 'uid' => $value['uid'],
                    'address_data' => $value['address'].'（'.$value['name'].'）',
                );
            }
        }

        $error['address_list'] = $address_list;
        echo json_encode($error);
        exit;
    }

    public function wait_get_order()
    {
        $this->data['title'] = '待接运单';

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->search_common();

        $this->data['total'] = 0;
        $this->data['data_list'] = array();
        if (!empty($this->data['shipper_driver_count_data']['vehicle_ids'])) {
            $where = array(
                'vehicle_id' => $this->data['shipper_driver_count_data']['vehicle_ids'],
                'order_type' => 2,
            );
            $data_list = $this->orders_service->get_orders_data_list($where);
            $this->data['total'] = count($data_list);

            // 分页初始化
            $config = array();
            $config['display_pages'] = FALSE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$this->data['search_str']);
            $config['total_rows'] = $this->data['total'];
            $config['per_page'] = $per_page;
            $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
            $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
            $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
            $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
            $this->pagination->initialize($config);

            $this->data['data_list'] = $this->orders_service->get_orders_data_list($where, $per_page, $cur_num, 'create_time', 'DESC');
            if ($this->data['data_list']) {
                foreach ($this->data['data_list'] as &$value) {
                    // 车辆信息
                    $value['vehicle_data'] = $this->vehicle_service->get_vehicle_by_id($value['vehicle_id']);
                    
                    // 司机信息
                    $value['driver_data'] = $this->driver_service->get_driver_by_id($value['vehicle_data']['driver_id']);
                    
                    // 车辆类型信息
                    $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);
                 }

                 $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'good_start_time', SORT_ASC);
            }
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        // 货运线路
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_shipper_route_options'] = $this->shipper_route_service->get_shipper_route_options($where);

        // 指定货车
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_current_shipper_driver_vehicle_options'] = $this->vehicle_service->get_current_shipper_driver_vehicle_options(0, $where);

        $this->load->view($this->appfolder.'/order/wait_get_order_view', $this->data);
    }

    public function wait_order()
    {
        $this->data['title'] = '待运运单';

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->search_common();

        $this->data['total'] = 0;
        $this->data['data_list'] = array();
        if (!empty($this->data['shipper_driver_count_data']['driver_ids'])) {
            $where = array(
                'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
                'order_type' => 3,
            );
            $data_list = $this->orders_service->get_orders_data_list($where);
            $this->data['total'] = count($data_list);

            // 分页初始化
            $config = array();
            $config['display_pages'] = FALSE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$this->data['search_str']);
            $config['total_rows'] = $this->data['total'];
            $config['per_page'] = $per_page;
            $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
            $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
            $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
            $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
            $this->pagination->initialize($config);

            $this->data['data_list'] = $this->orders_service->get_orders_data_list($where, $per_page, $cur_num, 'order_id', 'DESC');
            if ($this->data['data_list']) {
                foreach ($this->data['data_list'] as &$value) {
                    // 司机信息
                    $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);

                    // 车辆信息
                    $value['vehicle_data'] = $this->vehicle_service->get_vehicle_by_id($value['vehicle_id']);

                    // 车辆类型信息
                    $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                    $value['current_location'] = $current_location.' '.($tracking_data['create_time'] ? date('m-d H:i', strtotime($tracking_data['create_time'])) : '');
                 }

                 $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'good_end_time', SORT_ASC);
            }
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        // 货运线路
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_shipper_route_options'] = $this->shipper_route_service->get_shipper_route_options($where);

        // 指定货车
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_current_shipper_driver_vehicle_options'] = $this->vehicle_service->get_current_shipper_driver_vehicle_options(0, $where);

        $this->load->view($this->appfolder.'/order/wait_order_view', $this->data);
    }

    public function carry_order()
    {
        $this->data['title'] = '在途运单';

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->search_common();

        $this->data['total'] = 0;
        $this->data['data_list'] = array();
        if (!empty($this->data['shipper_driver_count_data']['driver_ids'])) {
            $where = array(
                'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
                'order_type' => 4,
            );
            $data_list = $this->orders_service->get_orders_data_list($where);
            $this->data['total'] = count($data_list);

            // 分页初始化
            $config = array();
            $config['display_pages'] = FALSE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$this->data['search_str']);
            $config['total_rows'] = $this->data['total'];
            $config['per_page'] = $per_page;
            $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
            $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
            $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
            $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
            $this->pagination->initialize($config);

            $this->data['data_list'] = $this->orders_service->get_orders_data_list($where, $per_page, $cur_num, 'order_id', 'DESC');
            if ($this->data['data_list']) {
                foreach ($this->data['data_list'] as &$value) {
                    // 司机信息
                    $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);

                    // 车辆信息
                    $value['vehicle_data'] = $this->vehicle_service->get_vehicle_by_id($value['vehicle_id']);

                    // 车辆类型信息
                    $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                    $value['current_location'] = $current_location.' '.($tracking_data['create_time'] ? date('m-d H:i', strtotime($tracking_data['create_time'])) : '');
                 }

                 $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'good_end_time', SORT_ASC);
            }
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        $this->load->view($this->appfolder.'/order/carry_order_view', $this->data);
    }

    public function history_order()
    {
        $this->data['history_type'] = $this->input->get('history_type', TRUE);
        $this->data['history_type'] = $this->data['history_type'] ? $this->data['history_type'] : 1;

        if ($this->data['history_type'] == 1) {
            $this->history_finish_order();
        } elseif ($this->data['history_type'] == 2) {
            $this->history_cancel_order();
        }
    }

    public function history_finish_order()
    {
        $this->data['title'] = '已完成运单 - 历史运单';

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->search_common();

        $this->data['shipper_route_id'] = $this->input->get('shipper_route_id', TRUE);
        $this->data['shipper_route_id'] = $this->data['shipper_route_id'] ? $this->data['shipper_route_id'] : 'all';

        $this->data['route_data'] = array();
        if ($this->data['shipper_route_id'] != 'all') {
            $where = array(
                'route_id' => $this->data['shipper_route_id'],
            );
            $this->data['route_data'] = $this->route_service->get_route_by_id($where);
        }

        $this->data['start_time'] = $this->input->get('start_time', TRUE);
        $this->data['start_time'] = $this->data['start_time'] > 0 ? strtotime($this->data['start_time'].' 00:00:00') : 0;
        $this->data['end_time'] = $this->input->get('end_time', TRUE);
        $this->data['end_time'] = $this->data['end_time'] > 0 ? strtotime($this->data['end_time'].' 23:59:59') : 0;

        $this->data['total'] = 0;
        $this->data['data_list'] = array();
        if (!empty($this->data['shipper_driver_count_data']['driver_ids'])) {
            $where = array(
                'shipper_id' => $this->shipper_info['shipper_ids'],
                'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
                'order_type' => 5,
            );
            $all_data_list = $this->orders_service->get_orders_data_list($where);
            $this->data['all_count'] = 0;
            $this->data['all_freight'] = 0;
            if ($all_data_list) {
                foreach ($all_data_list as $key => $value) {
                    $this->data['all_count']++;
                    $this->data['all_freight'] += $value['good_freight'];
                }
                $this->data['all_freight'] = sprintf("%0.2f", $this->data['all_freight'] / 10000);
            }

            $this->data['search_str'] .= '&history_type='.$this->data['history_type'];

            if (!empty($this->data['route_data'])) {
                $this->data['search_str'] .= '&shipper_route_id='.$this->data['shipper_route_id'];

                $where['start_city_id'] = $this->data['route_data']['start_city_id'];
                $where['end_city_id'] = $this->data['route_data']['end_city_id'];
            }

            if ($this->data['start_time']) {
                $this->data['search_str'] .= '&start_time='.date('Y-m-d', $this->data['start_time']);

                $where['good_start_time >='] = $this->data['start_time'];
            }

            if ($this->data['end_time']) {
                $this->data['search_str'] .= '&end_time='.date('Y-m-d', $this->data['end_time']);

                $where['good_start_time <='] = $this->data['end_time'];
            }

            $data_list = $this->orders_service->get_orders_data_list($where);
            $this->data['total'] = count($data_list);

            // 分页初始化
            $config = array();
            $config['display_pages'] = FALSE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$this->data['search_str']);
            $config['total_rows'] = $this->data['total'];
            $config['per_page'] = $per_page;
            $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
            $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
            $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
            $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
            $this->pagination->initialize($config);

            $this->data['data_list'] = $this->orders_service->get_orders_data_list($where, $per_page, $cur_num, 'order_id', 'DESC');
            if ($this->data['data_list']) {
                foreach ($this->data['data_list'] as &$value) {
                    // 司机信息
                    $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);

                    // 车辆信息
                    $value['vehicle_data'] = $this->vehicle_service->get_vehicle_by_id($value['vehicle_id']);

                    // 车辆类型信息
                    $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                    $value['current_location'] = $current_location.' '.($tracking_data['create_time'] ? date('m-d H:i', strtotime($tracking_data['create_time'])) : '');
                 }
                 $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'order_end_time', SORT_DESC);
            }
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        // 货运线路
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_shipper_route_options'] = $this->shipper_route_service->get_shipper_route_options($where, $this->data['shipper_route_id']);

        $this->load->view($this->appfolder.'/order/history_finish_order_view', $this->data);
    }

    public function ajax_get_track_driver_route()
    {
        $error = array(
            'code' => 'success',
            'driver_head_icon_http_file' => '',
            'track_data_list' => array(),
        );

        $order_id = $this->input->post('order_id', TRUE);

        if (!(is_numeric($order_id) && $order_id > 0)) {
            $error['code'] = 'order_id 参数错误';
            echo json_encode($error);
            exit;
        }

        $order_data = $this->orders_service->get_orders_by_id($order_id);

        $driver_data = $this->driver_service->get_driver_by_id($order_data['driver_id']);
        $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_head_icon']);
        $error['driver_head_icon_http_file'] = $attachment_data['http_file'];

        $where = array(
            'driver_id' => $order_data['driver_id'],
            'UNIX_TIMESTAMP(create_time) >=' => $order_data['good_start_time'],
            'UNIX_TIMESTAMP(create_time) <=' => $order_data['order_end_time'],
        );
        $track_data_list = $this->tracking_service->get_tracking_data_list($where);
        if ($track_data_list) {
            $interval_time = 5 * 60; // 5分钟
            $i = 0;
            foreach ($track_data_list as $value) {
                $create_time = strtotime($value['create_time']);
                $next_time = $interval_time * $i + $create_time;
                if ($next_time >= $create_time) {
                    if (empty($value['latitude']) || empty($value['longitude'])) {
                        continue;
                    }

                    $error['track_data_list'][] = array(
                        'speedInKPH' => intval($value['speedInKPH']),
                        'lat' => $value['latitude'],
                        'lng' => $value['longitude'],
                    );

                    $i++;
                }
            }
        }

        echo json_encode($error);
        exit;
    }

    public function ajax_confirm_order()
    {
        $error = array(
            'code' => 'success',
        );

        $order_id = $this->input->post('order_id', TRUE);

        if (!(is_numeric($order_id) && $order_id > 0)) {
            $error['code'] = 'order_id 参数错误';
            echo json_encode($error);
            exit;
        }

        $data = array(
            'is_finished' => 1,
        );
        $where = array(
            'order_id' => $order_id,
        );
        $this->common_model->update('orders', $data, $where);

        echo json_encode($error);
        exit;
    }

    public function ajax_comment_order()
    {
        $error = array(
            'code' => 'success',
        );

        $order_id = $this->input->post('order_id', TRUE);
        $comment_star = $this->input->post('comment_star[]', TRUE);
        $comment_text_array = $this->input->post('comment_text[]', TRUE);

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'is_comment' => 1,
        );
        $where = array(
            'order_id' => $order_id,
        );
        $this->common_model->update('orders', $data, $where);

        $order_data = $this->orders_service->get_orders_by_id($order_id);

        $where = array(
            'shipper_id' => $this->shipper_info['shipper_id'],
            'driver_id' => $order_data['driver_id'],
            'order_id' => $order_id,
        );
        $shipper_comment_driver_data = $this->comment_service->get_shipper_comment_driver_data($where);

        if (count($shipper_comment_driver_data) > 0) {
            $error['code'] = '请勿重新提交评价';
            echo json_encode($error);
            exit;
        }

        $comment_text = '';
        if (!empty($comment_text_array)) {
            foreach ($comment_text_array as $value) {
                $comment_text .= $value.",";
            }
            $comment_text = substr($comment_text, 0, -1);
        }

        $data = array(
            'shipper_id' => $this->shipper_info['shipper_id'],
            'driver_id' => $order_data['driver_id'],
            'order_id' => $order_id,
            'comment_star' => end($comment_star),
            'comment_text' => $comment_text,
            'cretime' => $time,
        );
        $this->common_model->insert('shipper_comment_driver', $data);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = '操作失败，请重新操作！';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }

    public function history_cancel_order()
    {
        $this->data['title'] = '已取消运单 - 历史运单';

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        // 货运公司货车数
        $shipper_driver_count_data = $this->shipper_driver_service->get_shipper_driver_count($this->shipper_info);

        $where = array(
            'driver_id' => $shipper_driver_count_data['driver_ids'],
            'order_type' => 6,
        );
        $data_list = $this->orders_service->get_orders_data_list($where);
        $this->data['total'] = count($data_list);

        // 分页初始化
        $config = array();
        $config['display_pages'] = FALSE;
        $config['page_query_string'] = TRUE;
        $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method());
        $config['total_rows'] = $this->data['total'];
        $config['per_page'] = $per_page;
        $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
        $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
        $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
        $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
        $this->pagination->initialize($config);

        $this->data['data_list'] = $this->orders_service->get_orders_data_list($where, $per_page, $cur_num, 'order_id', 'DESC');
        if ($this->data['data_list']) {
            $order_type_desc = $this->config->item('order_type_desc');
            foreach ($this->data['data_list'] as &$value) {
                $value['order_type_text'] = $order_type_desc[$value['order_type']];
             }
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        $this->load->view($this->appfolder.'/order/history_cancel_order_view', $this->data);
    }

    public function contract_order()
    {
        $this->data['title'] = '运输合同';

        $order_id = $this->input->get('order_id', TRUE);

        $this->data['order_data'] = $this->orders_service->get_orders_by_id($order_id);

        $where = array(
            'driver_id' => $this->data['order_data']['driver_id'],
        );
        $shipper_driver_data = $this->shipper_driver_service->get_shipper_driver_data($where);
        $shipper_company_data = $this->shipper_company_service->get_shipper_company_by_id($shipper_driver_data['shipper_company_id']);
        $shipper_data = $this->shipper_service->get_shipper_by_id($this->data['order_data']['shipper_id']);
        $driver_data = $this->driver_service->get_driver_by_id($shipper_driver_data['driver_id']);
        $where = array(
            'driver_id' => $shipper_driver_data['driver_id'],
        );
        $vehicle_data = $this->vehicle_service->get_vehicle_data($where);
        $where = array(
            'order_id' => $order_id,
            'order_type' => 4,
        );
        $order_log_data = $this->order_log_service->get_order_log_data($where, 1, 0);

        $order_num = '1208959';
        $this->data['contract_data'] = array(
            'shipper_company_name' => $shipper_company_data['shipper_company_name'],
            'order_num' => $order_num,
            'driver_name' => $driver_data['driver_name'],
            'vehicle_engine' => $vehicle_data['vehicle_engine'],
            'vehicle_card_num' => $vehicle_data['vehicle_card_num'],
            'driver_mobile' => $driver_data['driver_mobile'],
            'driver_license' => $driver_data['driver_license'],
            'driver_card_num' => $driver_data['driver_card_num'],
            'shipper_name' => $shipper_data['shipper_name'],
            'shipper_company_addr' => $shipper_company_data['shipper_company_addr'],
            'zipcode' => $shipper_company_data['zipcode'],
            'shipper_phone' => $shipper_company_data['shipper_phone'],
            'shipper_fax' => $shipper_company_data['shipper_fax'],
            'good_start_time' => $order_log_data['create_time'],
        );

        $this->load->view($this->appfolder.'/order/contract_order_view', $this->data);
    }
}