<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends Public_MY_Controller {

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

    public function vehicle_common()
    {
        $this->data['order_id'] = $this->input->get('order_id', TRUE);
        $this->data['order_id'] = $this->data['order_id'] ? $this->data['order_id'] : 0;

        $this->data['order_type'] = $this->input->get('order_type', TRUE);
        $this->data['order_type'] = $this->data['order_type'] ? $this->data['order_type'] : 4;

        $this->data['k'] = $this->input->get('k', TRUE);
        $this->data['k'] = $this->data['k'] ? $this->data['k'] : '';

        // 货运公司货车数
        $this->data['shipper_driver_count_data'] = $this->shipper_driver_service->get_shipper_driver_count($this->shipper_info);
        $this->data['vehicle_count'] = $this->data['shipper_driver_count_data']['count'];
        // 在途数
        $this->data['carry_count'] = $this->shipper_driver_service->get_order_driver_count($this->shipper_info, 4);
        // 待运数
        $this->data['wait_count'] = $this->shipper_driver_service->get_order_driver_count($this->shipper_info, 3);
        // 未承运数
        $this->data['sleep_count'] = $this->shipper_driver_service->get_sleep_count_count($this->shipper_info);

        // 货运线路
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_shipper_route_options'] = $this->shipper_route_service->get_shipper_route_options($where);

        // 出发地省份
        $where = array(
            'parent_id' => 1,
        );
        $this->data['get_region_options'] = $this->region_service->get_region_options(0, $where);

        // 指定货车
        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['get_current_shipper_driver_vehicle_options'] = $this->vehicle_service->get_current_shipper_driver_vehicle_options(0, $where);

        // 搜索字段非空
        $this->data['search_str'] = '?1';
        if (!empty($this->data['k'])) {
            $where = array(
                'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
                'driver_name LIKE' => '%'.$this->data['k'].'%',
            );
            $this->data['search_str'] .= '&k='.$this->data['k'];
            $search_driver_data_list = $this->driver_service->get_driver_data_list($where);
            if ($search_driver_data_list) {
                $search_driver_ids = array();
                foreach ($search_driver_data_list as $value) {
                    $search_driver_ids[] = $value['driver_id'];
                }

                $this->data['shipper_driver_count_data']['driver_ids'] = $search_driver_ids;
            }
        }
    }

    public function vehicle_list()
    {
        $this->data['title'] = '车队信息 - 我的车队';

        $this->vehicle_common();
        
        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->data['total'] = 0;
        $this->data['data_list'] = array();
        $this->data['js_lat_lng'] = array();
        if (!empty($this->data['shipper_driver_count_data']['driver_ids'])) {
            $data_list_where = array(
                'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
            );
            $tmp_data_list = $this->driver_service->get_driver_data_list($data_list_where);
            $this->data['total'] = count($tmp_data_list);

            // 分页初始化
            $config = array();
            $config['display_pages'] = FALSE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/vehicle_list/'.$this->data['search_str'].'&order_type='.$this->data['order_type']);
            $config['total_rows'] = $this->data['total'];
            $config['per_page'] = $per_page;
            $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
            $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
            $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
            $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
            $this->pagination->initialize($config);

            $all_data_list = $this->driver_service->get_driver_data_list($data_list_where, '', '', 'create_time', 'DESC');
            if ($all_data_list) {
                $order_type_desc = $this->config->item('order_type_desc');
                $i = 0;
                $time = time();
                $driver_anomaly_text_config = $this->config->item('driver_anomaly_text_config');
                foreach ($all_data_list as $all_value) {
                    $where = array(
                        'driver_id' => $all_value['driver_id'],
                    );
                    $all_value['order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $all_value['driver_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $tracking_unix_time = strtotime($tracking_data['create_time']);
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                    $all_value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                    // 剩余里程
                    $start_lat = $tracking_data['latitude'];
                    $start_lng = $tracking_data['longitude'];
                    $end_lat = $all_value['order_data']['end_location_lat'];
                    $end_lng = $all_value['order_data']['end_location_lng'];

                    // 上次运单路线和完成时间
                    $where = array(
                        'driver_id' => $all_value['driver_id'],
                        'order_type' => 5,
                    );
                    $all_value['finished_order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                    $all_value['stay_time'] = '-';
                    if (!empty($all_value['finished_order_data']['order_end_time'])) {
                        // 已停留时间
                        $all_value['stay_time'] = get_stay_time($all_value['finished_order_data']['order_end_time']);
                    }

                    // 异常
                    $is_anomaly = 0;
                    $anomaly_desc = '';

                    // 可用是否异常
                    if (empty($all_value['order_data'])) {
                        // 24 小时位置未上报
                        if (($time - $tracking_unix_time) >= (24 * 3600)) {
                            $is_anomaly = 1;
                            $anomaly_desc = $driver_anomaly_text_config[1];
                        // 无 tracking 数据
                        } elseif (empty($tracking_data)) {
                            $is_anomaly = 2;
                            $anomaly_desc = $driver_anomaly_text_config[2];
                        }
                    }

                    // 在途是否异常
                    if ($all_value['order_data']['order_type'] == 4) {
                        // 24 小时位置未上报
                        if (($time - $tracking_unix_time) >= (24 * 3600)) {
                            $is_anomaly = 1;
                            $anomaly_desc = $driver_anomaly_text_config[1];
                        // 运单预计到达时间已过当前时间 6 小时
                        } elseif (($time - $all_value['order_data']['good_end_time']) >= (6 * 3600)) {
                            $is_anomaly = 3;
                            $anomaly_desc = $driver_anomaly_text_config[3];
                        // 无 tracking 数据
                        } elseif (empty($tracking_data)) {
                            $is_anomaly = 2;
                            $anomaly_desc = $driver_anomaly_text_config[2];
                        }
                    }

                    $this->data['js_lat_lng'][$i] = array(
                        'order_id' => $all_value['order_data']['order_id'],
                        'driver_id' => $all_value['driver_id'],
                        'driver_name' => $all_value['driver_name'],
                        'driver_mobile' => $all_value['driver_mobile'],
                        'current_location' => $current_location.'&nbsp;'.date('m-d H:i', strtotime($tracking_data['create_time'])),
                        'order_type' => $all_value['order_data']['order_type'],
                        'order_type_desc' => !empty($all_value['order_data']) ? $order_type_desc[$all_value['order_data']['order_type']] : '',
                        'good_end_time' => date('m-d H:i', $all_value['order_data']['good_end_time']),
                        'lat' => $tracking_data['latitude'],
                        'lng' => $tracking_data['longitude'],
                        'start_lat' => $start_lat,
                        'start_lng' => $start_lng,
                        'end_lat' => $end_lat,
                        'end_lng' => $end_lng,
                        'stay_time' => $all_value['stay_time'],
                        'order_start_city' => $all_value['order_data']['order_start_city'],
                        'order_end_city' => $all_value['order_data']['order_end_city'],
                        'is_anomaly' => $is_anomaly,
                        'anomaly_desc' => $anomaly_desc,
                    );

                    // 该公司的订单非当前登录的货运公司，只可以查看司机当前位置
                    // if (!in_array($all_value['order_data']['shipper_id'], $this->shipper_info['shipper_ids'])) {
                    //     $this->data['js_lat_lng'][$i]['order_type'] = 5;
                    // }

                    $i++;
                }
            }
            $this->data['js_lat_lng'] = json_encode($this->data['js_lat_lng']);

            $this->data['data_list'] = $this->driver_service->get_driver_data_list($data_list_where, $per_page, $cur_num, 'create_time', 'DESC');
            if ($this->data['data_list']) {
                $order_type_desc = $this->config->item('order_type_desc');
                foreach ($this->data['data_list'] as &$value) {
                    // 上次运单路线和完成时间
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'order_type' => 5,
                    );
                    $value['finished_order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                    $value['order_type'] = !empty($value['finished_order_data']) ? $order_type_desc[$value['finished_order_data']['order_type']] : '';

                    // 司机头像
                    $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_head_icon']);
                    $value['driver_head_icon_http_file'] = $attachment_data['http_file'];

                    // 车辆信息
                    $where = array(
                        'driver_id' => $value['driver_id'],
                    );
                    $value['vehcle_data'] = $this->vehicle_service->get_vehicle_data($where);
                    if (!empty($value['vehcle_data'])) {
                        // 车辆类型信息
                        $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehcle_data']['vehicle_type']);
                    }

                    $where = array(
                        'driver_id' => $value['driver_id'],
                    );
                    $value['order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');

                    // 合作次数
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'order_type' => 5,
                    );
                    $value['order_count'] = $this->orders_service->get_orders_count($where);

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $value['driver_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                    $value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                    // 已停留时间
                    $value['stay_time'] = get_stay_time($value['finished_order_data']['order_end_time']);

                    $value['order_type'] = !empty($value['order_data']['order_type']) ? $order_type_desc[$value['order_data']['order_type']] : '';
                 }

                 $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'order_count', SORT_DESC);
            }
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        // 获取货运公司省份
        $company_lat_lng = get_lat_lng_by_location($this->shipper_info['shipper_company_data']['shipper_company_addr']);
        $this->data['company_city'] = '上海市';
        $this->data['company_city'] = get_location_by_lat_lng($company_lat_lng['lat'], $company_lat_lng['lng']);

        $this->load->view($this->appfolder.'/vehicle/vehicle_list_view', $this->data);
    }

    public function index()
    {
        $this->data['title'] = '在途车辆 - 我的车队';

        $this->vehicle_common();

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->data['total'] = 0;
        $this->data['data_list'] = array();
        $this->data['js_lat_lng'] = array();

        if (!empty($this->shipper_info['carry_driver_ids'])) {
            foreach ($this->shipper_info['carry_driver_ids'] as $key => $driver_id) {
                if (!in_array($driver_id, $this->data['shipper_driver_count_data']['driver_ids'])) {
                    unset($this->shipper_info['carry_driver_ids'][$key]);
                }
            }
        }

        if (!empty($this->shipper_info['carry_driver_ids'])) {
            $data_list_where = array(
                'driver_id' => $this->shipper_info['carry_driver_ids'],
            );
            $tmp_data_list = $this->vehicle_service->get_vehicle_data_list($data_list_where);
            $this->data['total'] = count($tmp_data_list);

            // 分页初始化
            $config = array();
            $config['display_pages'] = FALSE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/'.$this->data['search_str'].'&order_type='.$this->data['order_type']);
            $config['total_rows'] = $this->data['total'];
            $config['per_page'] = $per_page;
            $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
            $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
            $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
            $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
            $this->pagination->initialize($config);

            $all_data_list = $this->vehicle_service->get_vehicle_data_list($data_list_where, '', '', 'create_time', 'DESC');
            if ($all_data_list) {
                $order_type_desc = $this->config->item('order_type_desc');
                $time = time();
                foreach ($all_data_list as $all_value) {
                    $where = array(
                        'driver_id' => $all_value['driver_id'],
                        'vehicle_id' => $all_value['vehicle_id'],
                    );
                    $all_value['order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                    $all_value['order_type'] = !empty($all_value['order_data']) ? $order_type_desc[$all_value['order_data']['order_type']] : '';

                    // 司机信息
                    $all_value['driver_data'] = $this->driver_service->get_driver_by_id($all_value['driver_id']);

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $all_value['driver_id'],
                        'vehicle_id' => $all_value['vehicle_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $tracking_unix_time = strtotime($tracking_data['create_time']);
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);

                    // 剩余里程
                    $start_lat = $tracking_data['latitude'];
                    $start_lng = $tracking_data['longitude'];
                    $end_lat = $all_value['order_data']['end_location_lat'];
                    $end_lng = $all_value['order_data']['end_location_lng'];

                    // 异常
                    $is_anomaly = 0;
                    $anomaly_desc = '';

                    // 可用是否异常
                    if ($all_value['order_data']['order_type'] == 3) {
                        // 24 小时位置未上报
                        if (($time - $tracking_unix_time) >= (24 * 3600)) {
                            $is_anomaly = $driver_anomaly_text_config[1];
                            $anomaly_desc = '24小时未上报';
                        // 无 tracking 数据
                        } elseif (empty($tracking_data)) {
                            $is_anomaly = $driver_anomaly_text_config[2];
                        }
                    }

                    // 在途是否异常
                    if ($all_value['order_data']['order_type'] == 4) {
                        // 24 小时位置未上报
                        if (($time - $tracking_unix_time) >= (24 * 3600)) {
                            $is_anomaly = $driver_anomaly_text_config[1];
                        // 运单预计到达时间已过当前时间 6 小时
                        } elseif (($time - $all_value['order_data']['good_end_time']) >= (6 * 3600)) {
                            $is_anomaly = $driver_anomaly_text_config[3];
                        // 无 tracking 数据
                        } elseif (empty($tracking_data)) {
                            $is_anomaly = $driver_anomaly_text_config[2];
                        }
                    }

                    $this->data['js_lat_lng'][] = array(
                        'order_id' => $all_value['order_data']['order_id'],
                        'driver_id' => $all_value['driver_data']['driver_id'],
                        'driver_name' => $all_value['driver_data']['driver_name'],
                        'driver_mobile' => $all_value['driver_data']['driver_mobile'],
                        'current_location' => $current_location.'&nbsp;'.date('m-d H:i', strtotime($tracking_data['create_time'])),
                        'order_type' => $all_value['order_data']['order_type'],
                        'order_type_desc' => $order_type_desc[$all_value['order_data']['order_type']],
                        'good_end_time' => date('m-d H:i', $all_value['order_data']['good_end_time']),
                        'lat' => $tracking_data['latitude'],
                        'lng' => $tracking_data['longitude'],
                        'start_lat' => $start_lat,
                        'start_lng' => $start_lng,
                        'end_lat' => $end_lat,
                        'end_lng' => $end_lng,
                        'order_start_city' => $all_value['order_data']['order_start_city'],
                        'order_end_city' => $all_value['order_data']['order_end_city'],
                        'is_anomaly' => $is_anomaly,
                    );
                }
            }
            $this->data['js_lat_lng'] = json_encode($this->data['js_lat_lng']);

            $this->data['data_list'] = $this->vehicle_service->get_vehicle_data_list($data_list_where, $per_page, $cur_num, 'create_time', 'DESC');
            if ($this->data['data_list']) {
                $order_type_desc = $this->config->item('order_type_desc');
                foreach ($this->data['data_list'] as $key => &$value) {
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                    );
                    $value['order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                    $value['order_type'] = !empty($value['order_data']) ? $order_type_desc[$value['order_data']['order_type']] : '';

                    // 上次运单路线和完成时间
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                        'order_type' => 5,
                    );
                    $value['finished_order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                    $value['order_type'] = !empty($value['finished_order_data']) ? $order_type_desc[$value['finished_order_data']['order_type']] : '';

                    // 司机信息
                    $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);
                    // 司机头像
                    $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_data']['driver_head_icon']);
                    $value['driver_head_icon_http_file'] = $attachment_data['http_file'];

                    // 车辆类型信息
                    $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                    // 合作次数
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                        'order_type' => 5,
                    );
                    $value['order_count'] = $this->orders_service->get_orders_count($where);

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                    $value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                    // 已停留时间
                    $value['stay_time'] = get_stay_time($value['finished_order_data']['order_end_time']);

                    $value['order_type'] = $order_type_desc[$value['order_data']['order_type']];
                 }

                 $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'order_count', SORT_DESC);
            }
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        $this->load->view($this->appfolder.'/vehicle/vehicle_view', $this->data);
    }

    public function sleep_vehicle()
    {
        $this->data['title'] = '车队信息 - 我的车队';

        $this->vehicle_common();
        
        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->data['total'] = 0;
        $this->data['data_list'] = array();
        $this->data['js_lat_lng'] = array();

        if (!empty($this->shipper_info['sleep_driver_ids'])) {
            foreach ($this->shipper_info['sleep_driver_ids'] as $key => $driver_id) {
                if (!in_array($driver_id, $this->data['shipper_driver_count_data']['driver_ids'])) {
                    unset($this->shipper_info['sleep_driver_ids'][$key]);
                }
            }
        }

        if (!empty($this->shipper_info['sleep_driver_ids'])) {
            $data_list_where = array(
                'driver_id' => $this->shipper_info['sleep_driver_ids'],
            );
            $tmp_data_list = $this->vehicle_service->get_vehicle_data_list($data_list_where);
            $this->data['total'] = count($tmp_data_list);

            // 分页初始化
            $config = array();
            $config['display_pages'] = FALSE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/vehicle_list/'.$this->data['search_str'].'&order_type='.$this->data['order_type']);
            $config['total_rows'] = $this->data['total'];
            $config['per_page'] = $per_page;
            $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
            $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
            $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
            $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
            $this->pagination->initialize($config);

            $all_data_list = $this->vehicle_service->get_vehicle_data_list($data_list_where, '', '', 'create_time', 'DESC');
            if ($all_data_list) {
                $time = time();
                foreach ($all_data_list as $all_value) {
                    // 司机信息
                    $all_value['driver_data'] = $this->driver_service->get_driver_by_id($all_value['driver_id']);

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $all_value['driver_id'],
                        'vehicle_id' => $all_value['vehicle_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $tracking_unix_time = strtotime($tracking_data['create_time']);
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);

                    // 上次运单路线和完成时间
                    $where = array(
                        'driver_id' => $all_value['driver_id'],
                        'order_type' => 5,
                    );
                    $all_value['finished_order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                    $all_value['stay_time'] = '-';
                    if (!empty($all_value['finished_order_data']['order_end_time'])) {
                        // 已停留时间
                        $all_value['stay_time'] = get_stay_time($all_value['finished_order_data']['order_end_time']);
                    }

                    // 异常
                    $is_anomaly = 0;

                    // 24 小时位置未上报
                    if (($time - $tracking_unix_time) >= (24 * 3600)) {
                        $is_anomaly = $driver_anomaly_text_config[1];
                    // 无 tracking 数据
                    } elseif (empty($tracking_data)) {
                        $is_anomaly = $driver_anomaly_text_config[2];
                    }

                    $this->data['js_lat_lng'][] = array(
                        'driver_id' => $all_value['driver_data']['driver_id'],
                        'driver_name' => $all_value['driver_data']['driver_name'],
                        'driver_mobile' => $all_value['driver_data']['driver_mobile'],
                        'current_location' => $current_location.'&nbsp;'.date('m-d H:i', strtotime($tracking_data['create_time'])),
                        'lat' => $tracking_data['latitude'],
                        'lng' => $tracking_data['longitude'],
                        'stay_time' => $all_value['stay_time'],
                        'is_anomaly' => $is_anomaly,
                    );
                }
            }
            $this->data['js_lat_lng'] = json_encode($this->data['js_lat_lng']);

            $this->data['data_list'] = $this->vehicle_service->get_vehicle_data_list($data_list_where, $per_page, $cur_num, 'create_time', 'DESC');
            if ($this->data['data_list']) {
                $order_type_desc = $this->config->item('order_type_desc');
                foreach ($this->data['data_list'] as $key => &$value) {
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                    );
                    $order_data = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                    $value['order_type'] = !empty($order_data) ? $order_type_desc[$order_data['order_type']] : '';

                    // 上次运单路线和完成时间
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                        'order_type' => 5,
                    );
                    $value['finished_order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');

                    // 司机信息
                    $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);
                    // 司机头像
                    $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_data']['driver_head_icon']);
                    $value['driver_head_icon_http_file'] = $attachment_data['http_file'];

                    // 车辆类型信息
                    $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                    // 合作次数
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                        'order_type' => 5,
                    );
                    $value['order_count'] = $this->orders_service->get_orders_count($where);

                    // 当前位置信息
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'vehicle_id' => $value['vehicle_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                    $value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                    // 已停留时间
                    $value['stay_time'] = get_stay_time($value['finished_order_data']['order_end_time']);
                 }

                 $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'order_count', SORT_DESC);
            }
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        // 获取货运公司省份
        $company_lat_lng = get_lat_lng_by_location($this->shipper_info['shipper_company_data']['shipper_company_addr']);
        $this->data['company_city'] = '上海市';
        $this->data['company_city'] = get_location_by_lat_lng($company_lat_lng['lat'], $company_lat_lng['lng']);

        $this->load->view($this->appfolder.'/vehicle/sleep_vehicle_view', $this->data);
    }

    public function ajax_send_vehicle_message()
    {
        $error = array(
            'code' => 'success'
        );

        $driver_id = $this->input->post('driver_id', TRUE);
        $title = $this->shipper_info['shipper_company_data']['shipper_company_name'];
        $content = $this->input->post('content', TRUE);
        $content = $title."-".$content;

        $driver_data = $this->driver_service->get_driver_by_id($driver_id);

        $push_st = push_xingeapp($driver_data['driver_mobile'], 2, $content);

        $this->common_model->trans_begin();

        $time = time();

        // 记录日志
        $data = array(
            'driver_id' => $driver_id,
            'push_desc' => $push_st,
            'cretime' => $time,
        );
        $this->common_model->insert('xingeapp_driver_log', $data);

        // 司机日志
        $data = array(
            'driver_id' => $driver_id,
            'title' => 'public_driver_message',
            'content' => $content,
            'cretime' => $time,
        );
        $this->common_model->insert('driver_message', $data);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }

    public function ajax_del_vehicle()
    {
        $error = array(
            'code' => 'success'
        );

        $driver_id = $this->input->post('driver_id', TRUE);

        if (!(is_numeric($driver_id) && $driver_id > 0)) {
            $error['code'] = 'driver_id 参数错误';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
            'driver_id' => $driver_id,
        );
        $this->common_model->delete('shipper_driver', $where);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = '操作失败';
            echo json_encode($error);
            exit;
        }
        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }

    public function ajax_start_location_baidumap_place()
    {
        $error = array(
            'code' => 'success'
        );

        $start_province_id = intval($this->input->post('start_province_id', TRUE));
        $start_province_data = '';
        if (!empty($start_province_id)) {
            $start_province_data = $this->region_service->get_region_by_id($start_province_id);
        }

        $region = '全国';
        if (!empty($start_province_data)) {
            $region = $start_province_data['region_name'];
        }

        $q = trim($this->input->post('good_load_addr', TRUE));

        if (empty($q)) {
            $error['code'] = '请输入运单起点';
            echo json_encode($error);
            exit;
        }

        $url = "http://api.map.baidu.com/place/v2/search";
        $params = array(
            'q' => $q,
            'region' => $region,
            'scope' => 2,
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
                    'name' => $value['name'],
                    'address' => $value['address'],
                    // 'street_id' => $value['street_id'],
                    // 'telephone' => $value['telephone'],
                    // 'detail' => $value['detail'],
                    // 'uid' => $value['uid'],
                    'address_data' => $value['name'].'（'.$value['address'].'）',
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

        $end_province_id = intval($this->input->post('end_province_id', TRUE));
        $end_province_data = '';
        if (!empty($end_province_id)) {
            $end_province_data = $this->region_service->get_region_by_id($end_province_id);
        }

        $region = '全国';
        if (!empty($end_province_data)) {
            $region = $end_province_data['region_name'];
        }

        $q = trim($this->input->post('good_unload_addr', TRUE));

        if (empty($q)) {
            $error['code'] = '请输入卸货地点';
            echo json_encode($error);
            exit;
        }

        $url = "http://api.map.baidu.com/place/v2/search";
        $params = array(
            'q' => $q,
            'region' => $region,
            'scope' => 2,
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
                    'name' => $value['name'],
                    'address' => $value['address'],
                    // 'street_id' => $value['street_id'],
                    // 'telephone' => $value['telephone'],
                    // 'detail' => $value['detail'],
                    // 'uid' => $value['uid'],
                    'address_data' => $value['name'].'（'.$value['address'].'）',
                );
            }
        }

        $error['address_list'] = $address_list;
        echo json_encode($error);
        exit;
    }

    public function ajax_do_publish_order()
    {
        $error = array(
            'code' => 'success'
        );

        $start_city_id = $this->input->get_post('start_city_id', TRUE);
        $good_load_addr_lat_lng = $this->input->post('good_load_addr_lat_lng', TRUE);
        $good_load_addr_lat_lng = json_decode($good_load_addr_lat_lng, TRUE);
        $start_lat = $good_load_addr_lat_lng['lat'];
        $start_lng = $good_load_addr_lat_lng['lng'];
        $start_location = $this->input->post('good_load_addr', TRUE);

        $end_city_id = $this->input->get_post('end_city_id', TRUE);
        $good_unload_addr_lat_lng = $this->input->post('good_unload_addr_lat_lng', TRUE);
        $good_unload_addr_lat_lng = json_decode($good_unload_addr_lat_lng, TRUE);
        $end_lat = $good_unload_addr_lat_lng['lat'];
        $end_lng = $good_unload_addr_lat_lng['lng'];
        $end_location = $this->input->post('good_unload_addr', TRUE);

        $vehicle_id = $this->input->post('vehicle_id', TRUE);

        if (empty($start_city_id)) {
            if (empty($start_lat) || empty($start_lng)) {
                $error['code'] = '起点地址无效';
                echo json_encode($error);
                exit;
            }
        }

        if (empty($end_city_id)) {
            if (empty($end_lat) || empty($end_lng)) {
                $error['code'] = '终点地址无效';
                echo json_encode($error);
                exit;
            }
        }

        $where = array(
            'level' => 2,
        );
        $region_data_list = $this->region_service->get_region_data_list($where);

        // 起点判断
        if (!empty($start_lat) && !empty($start_lng) && !empty($start_location)) {
            $start_city_name = get_location_by_lat_lng($start_lat, $start_lng);

            foreach ($region_data_list as $region_value) {
                if (stripos($start_city_name, $region_value['region_name']) !== FALSE) {
                    $start_city_id = $region_value['id'];
                    break;
                }
            }

            $start_city_data = $this->region_service->get_region_by_id($start_city_id);
            $start_province_data = $this->region_service->get_region_by_id($start_city_data['parent_id']);
            if ($start_province_data['region_name'] == $start_city_data['region_name']) {
                $start_province_data['region_name'] = '';
            }
        } else {
            $start_city_data = $this->region_service->get_region_by_id($start_city_id);
            $start_province_data = $this->region_service->get_region_by_id($start_city_data['parent_id']);
            if ($start_province_data['region_name'] == $start_city_data['region_name']) {
                $start_province_data['region_name'] = '';
            }

            $start_lat = $start_city_data['latitude'];
            $start_lng = $start_city_data['longitude'];
            // $start_location = $start_province_data['region_name'].$start_city_data['region_name'];
            $start_location = '';
        }

        // 终点判断
        if (!empty($end_lat) && !empty($end_lng) && !empty($end_location)) {
            $end_city_name = get_location_by_lat_lng($end_lat, $end_lng);

            foreach ($region_data_list as $region_value) {
                if (stripos($end_city_name, $region_value['region_name']) !== FALSE) {
                    $end_city_id = $region_value['id'];
                    break;
                }
            }

            $end_city_data = $this->region_service->get_region_by_id($end_city_id);
            $end_province_data = $this->region_service->get_region_by_id($end_city_data['parent_id']);
            if ($end_province_data['region_name'] == $end_city_data['region_name']) {
                $end_province_data['region_name'] = '';
            }
        } else {
            $end_city_data = $this->region_service->get_region_by_id($end_city_id);
            $end_province_data = $this->region_service->get_region_by_id($end_city_data['parent_id']);
            if ($end_province_data['region_name'] == $end_city_data['region_name']) {
                $end_province_data['region_name'] = '';
            }

            $end_lat = $end_city_data['latitude'];
            $end_lng = $end_city_data['longitude'];
            // $end_location = $end_province_data['region_name'].$end_city_data['region_name'];
            $end_location = '';
        }

        $this->common_model->trans_begin();

        $time = time();

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
            'shipper_company_id' => $this->shipper_info['company_id'],
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
                'shipper_company_id' => $this->shipper_info['company_id'],
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
            'shipper_company_id' => $this->shipper_info['company_id'],
            'route_id' => $route_data['route_id'],
        );
        $shipper_route_data = $this->shipper_route_service->get_shipper_route_data($where);

        // 车辆所属司机信息
        $where = array(
            'vehicle_id' => $vehicle_id,
        );
        $vehicle_data = $this->vehicle_service->get_vehicle_data($where);
        $driver_data = $this->driver_service->get_driver_by_id($vehicle_data['driver_id']);

        $order_num = get_order_sn($this->shipper_info['shipper_id']);

        $data = array(
            'shipper_id' => $this->shipper_info['shipper_id'],
            'good_name' => '公版WEB订单',
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
            'good_load_addr' => $start_location,
            'good_load_time' => $good_load_time,
            'good_start_time' => $good_start_time,
            'good_end_time' => $good_end_time,
            'order_validity' => 24, // 有效期，默认24
            'order_overdue' => $time + 24 * 3600,   // 失效时间，创建时间 + 有效期
            'good_unload_addr' => $end_location,
            'good_unload_time' => $good_unload_time,
            'good_freight' => !empty($shipper_route_data['shipper_route_freight']) ? $shipper_route_data['shipper_route_freight'] : 0,
            'good_margin' => !empty($shipper_route_data['shipper_route_margin']) ? $shipper_route_data['shipper_route_margin'] : 0,
            'good_mobile' => $driver_data['driver_mobile'],
            'good_contact' => $end_location,
            'good_volume' => 100,   // 默认100立方
            'good_load' => 35,  // 默认35吨
            'good_nums' => 1,   // 默认1
            'order_status' => 1,
            'release_id' => $this->shipper_info['shipper_id'],
            'order_type' => 4,
            'create_time' => $time,
            'driver_id' => $vehicle_data['driver_id'],
            'vehicle_id' => $vehicle_data['vehicle_id'],
            'order_num' => $order_num,
            'is_view_draft' => 2,
            'start_location_lat' => $start_location_lat,
            'start_location_lng' => $start_location_lng,
            'end_location_lat' => $end_location_lat,
            'end_location_lng' => $end_location_lng,
            'cre_from' => 4,
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
                $des = '公版WEB - 待接';
            } elseif ($i == 3) {
                $des = '公版WEB - 已接';
            } elseif ($i == 4) {
                $des = '公版WEB - 发车';
            }

            $where = array(
                'order_id' => $order_id,
                'driver_id' => $driver_data['driver_id'],
                'vehicle_id' => $vehicle_data['vehicle_id'],
                'order_type' => $i,
            );
            $order_log_data = $this->order_log_service->get_order_log_data($where);
            if (empty($order_log_data)) {
                $data = array(
                    'order_id' => $order_id,
                    'driver_id' => $driver_data['driver_id'],
                    'vehicle_id' => $vehicle_data['vehicle_id'],
                    'order_type' => $i,
                    'opereation_id' => $driver_data['driver_id'],
                    'create_time' => date('Y-m-d H:i:s', $time + ($i - 1)),
                    'des' => $des,
                );
                $this->common_model->insert('order_log', $data);
            }
        }

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = '操作失败';
            echo json_encode($error);
            exit;
        }
        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }

    public function ajax_search_vehicle_card_num()
    {
        $error = array(
            'code' => 'success'
        );

        $vehicle_card_num = trim($this->input->post('vehicle_card_num', TRUE));

        if (empty($vehicle_card_num)) {
            $error['code'] = '请输入车牌号码';
            echo json_encode($error);
            exit;
        }

        $where = array(
            'vehicle_card_num LIKE' => '%'.$vehicle_card_num.'%',
        );
        $data_list = $this->vehicle_service->get_vehicle_data_list($where);
        if ($data_list) {
            foreach ($data_list as $key => &$value) {
                // 司机信息
                $driver_data = $this->driver_service->get_driver_by_id($value['driver_id']);
                if (!$driver_data) {
                    unset($data_list[$key]);
                    continue;
                }
                $value['driver_name'] = $driver_data['driver_name'];
                $value['driver_mobile'] = $driver_data['driver_mobile'];

                // 车辆信息
                $vehicle_type_data = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);
                $value['type_id'] = $vehicle_type_data['type_id'];
                $value['type_name'] = $vehicle_type_data['type_name'];

                $value['item_data'] = <<<EOT
                <table border="0" width="280" cellpadding="5" cellspacing="3">
                    <tr>
                        <td width="100" align="left">{$value['vehicle_card_num']}</td>
                        <td width="100" align="right">{$driver_data['driver_mobile']}</td>
                        <td align="right">{$driver_data['driver_name']}</td>
                    </tr>
                </table>
EOT;
            }
        }

        $error['data_list'] = $data_list;
        echo json_encode($error);
        exit;
    }

    public function ajax_search_driver_mobile()
    {
        $error = array(
            'code' => 'success'
        );

        $driver_mobile = trim($this->input->post('driver_mobile', TRUE));

        if (empty($driver_mobile)) {
            $error['code'] = '请输入手机号码';
            echo json_encode($error);
            exit;
        }

        $where = array(
            'driver_mobile LIKE' => '%'.$driver_mobile.'%',
        );
        $data_list = $this->driver_service->get_driver_data_list($where);
        if ($data_list) {
            foreach ($data_list as $key => &$value) {
                // 车辆信息
                $where = array(
                    'driver_id' => $value['driver_id'],
                );
                $vehicle_data = $this->vehicle_service->get_vehicle_data($where);
                if (empty($vehicle_data)) {
                    unset($data_list[$key]);
                    continue;
                }
                $value['vehicle_card_num'] = $vehicle_data['vehicle_card_num'];
                $value['vehicle_length'] = $vehicle_data['vehicle_length'];

                // 车辆信息
                $vehicle_type_data = $this->vehicle_service->get_vehicle_type_by_id($vehicle_data['vehicle_type']);
                $value['type_id'] = $vehicle_type_data['type_id'];
                $value['type_name'] = $vehicle_type_data['type_name'];

                $value['item_data'] = <<<EOT
                <table border="0" width="280" cellpadding="5" cellspacing="3">
                    <tr>
                        <td width="100" align="left">{$vehicle_data['vehicle_card_num']}</td>
                        <td width="100" align="right">{$value['driver_mobile']}</td>
                        <td align="right">{$value['driver_name']}</td>
                    </tr>
                </table>
EOT;
            }
        }

        $error['data_list'] = $data_list;
        echo json_encode($error);
        exit;
    }

    public function ajax_do_publish_vehicle()
    {
        $error = array(
            'code' => 'success'
        );

        $vehicle_card_num = $this->input->post('vehicle_card_num', TRUE);

        $where = array(
            'vehicle_card_num' => $vehicle_card_num,
        );
        $vehicle_data = $this->vehicle_service->get_vehicle_data($where);

        if (!$vehicle_data) {
            $error['code'] = '车牌号码填写错误';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
            'driver_id' => $vehicle_data['driver_id'],
        );
        $shipper_driver_data = $this->shipper_driver_service->get_shipper_driver_data($where);
        if ($shipper_driver_data) {
            $error['code'] = '该车辆已经存在';
            echo json_encode($error);
            exit;
        }

        $data = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
            'driver_id' => $vehicle_data['driver_id'],
            'create_time' => date("Y-m-d H:i:s", $time),
        );
        $insert_id = $this->common_model->insert('shipper_driver', $data);

        // 增加积分
        $this->shipper_company_service->update_shipper_company_score($this->shipper_info, 2);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = '操作失败';
            echo json_encode($error);
            exit;
        }
        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }
}