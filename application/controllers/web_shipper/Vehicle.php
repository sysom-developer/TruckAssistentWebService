<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends MY_Controller {

    public function vehicle_common()
    {
        $this->data['order_type'] = $this->input->get('order_type', TRUE);
        $this->data['order_type'] = $this->data['order_type'] ? $this->data['order_type'] : 4;

        $this->data['search_type'] = $this->input->get('search_type', TRUE);
        $this->data['search_type'] = $this->data['search_type'] ? $this->data['search_type'] : 'good_end_time';

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

        $where = array(
            'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
        );
        $tmp_data_list = $this->vehicle_service->get_vehicle_data_list($where);
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

        $this->data['data_list'] = $this->vehicle_service->get_vehicle_data_list($where, $per_page, $cur_num, 'create_time', 'DESC');
        $this->data['js_lat_lng'] = array();
        if ($this->data['data_list']) {
            $order_type_desc = $this->config->item('order_type_desc');
            foreach ($this->data['data_list'] as &$value) {
                // 司机信息
                $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);
                // 司机头像
                $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_data']['driver_head_icon']);
                $value['driver_head_icon_http_file'] = $attachment_data['http_file'];

                // 车辆类型信息
                $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                // 上次运单路线和完成时间
                $where = array(
                    'driver_id' => $value['driver_id'],
                    'vehicle_id' => $value['vehicle_id'],
                );
                $value['order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                $value['order_type'] = !empty($value['order_data']) ? $order_type_desc[$value['order_data']['order_type']] : '';

                // 合作次数
                $value['order_count'] = $this->orders_service->get_orders_count($where);

                // 当前位置信息
                $where = array(
                    'driver_id' => $value['driver_id'],
                    'vehicle_id' => $value['vehicle_id'],
                );
                $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                $value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                $this->data['js_lat_lng'][] = array(
                    'driver_name' => $value['driver_data']['driver_name'],
                    'driver_mobile' => $value['driver_data']['driver_mobile'],
                    'lat' => $tracking_data['latitude'],
                    'lng' => $tracking_data['longitude'],
                );

                // 已停留时间
                $value['stay_time'] = get_stay_time($value['order_data']['order_end_time']);
             }
        }

        $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'order_count', SORT_DESC);

        $this->data['js_lat_lng'] = json_encode($this->data['js_lat_lng']);

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        $this->load->view($this->appfolder.'/vehicle/vehicle_list_view', $this->data);
    }

    public function index()
    {
        $this->vehicle_common();

        $title_text = $this->data['order_type'] == 4 ? '在途车辆 - ' : '待运车辆 - ';

        $this->data['title'] = $title_text.'我的车队';

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $where = array(
            'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
            'order_type' => $this->data['order_type'],
        );
        $data_list = $this->orders_service->get_orders_data_list($where);
        $this->data['total'] = count($data_list);

        // 分页初始化
        $config = array();
        $config['display_pages'] = FALSE;
        $config['page_query_string'] = TRUE;
        $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/index/?order_type='.$this->data['order_type']);
        $config['total_rows'] = $this->data['total'];
        $config['per_page'] = $per_page;
        $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
        $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
        $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
        $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
        $this->pagination->initialize($config);

        $this->data['data_list'] = $this->orders_service->get_orders_data_list($where, $per_page, $cur_num, $this->data['search_type'], 'DESC');
        $this->data['js_lat_lng'] = array();
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
                $value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                $this->data['js_lat_lng'][] = array(
                    'driver_name' => $value['driver_data']['driver_name'],
                    'driver_mobile' => $value['driver_data']['driver_mobile'],
                    'lat' => $tracking_data['latitude'],
                    'lng' => $tracking_data['longitude'],
                );
             }
        }
        $this->data['js_lat_lng'] = json_encode($this->data['js_lat_lng']);

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        $this->load->view($this->appfolder.'/vehicle/vehicle_view', $this->data);
    }

    public function calendar()
    {
        $this->data['title'] = '日历 - 我的车队';

        $this->load->view($this->appfolder.'/vehicle/calendar_view', $this->data);
    }

    public function sleep_vehicle()
    {
        $this->data['title'] = '未承运车辆 - 我的车队';

        $this->vehicle_common();

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $where = array(
            'driver_id' => $this->data['shipper_driver_count_data']['driver_ids'],
        );
        $this->data['total'] = $this->shipper_driver_service->get_sleep_count_count($this->shipper_info);

        // 分页初始化
        $config = array();
        $config['display_pages'] = FALSE;
        $config['page_query_string'] = TRUE;
        $config['base_url'] = site_url(''.$this->appfolder.'/'.$this->router->fetch_class().'/sleep_vehicle/?order_type='.$this->data['order_type']);
        $config['total_rows'] = $this->data['total'];
        $config['per_page'] = $per_page;
        $config['first_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/prev.gif').'">';
        $config['last_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/next.gif').'">';
        $config['next_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/nexta.gif').'">';
        $config['prev_link'] = '<img src="'.static_url('static/images/'.$this->appfolder.'/preva.gif').'">';
        $this->pagination->initialize($config);

        $this->data['data_list'] = $this->shipper_driver_service->get_sleep_count_data_list($this->shipper_info, $where, $per_page, $cur_num, 'driver_id', 'DESC');
        $this->data['js_lat_lng'] = array();
        if ($this->data['data_list']) {
            $time = time();
            foreach ($this->data['data_list'] as &$value) {
                // 司机信息
                $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);

                // 车辆类型信息
                $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                // 上次运单路线和完成时间
                $where = array(
                    'driver_id' => $value['driver_id'],
                    'vehicle_id' => $value['vehicle_id'],
                    'order_type' => 5,
                );
                $value['order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                $value['order_end_time'] = $value['order_data']['order_end_time'];

                // 当前位置信息
                $where = array(
                    'driver_id' => $value['driver_id'],
                    'vehicle_id' => $value['vehicle_id'],
                );
                $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                $value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                $this->data['js_lat_lng'][] = array(
                    'driver_name' => $value['driver_data']['driver_name'],
                    'driver_mobile' => $value['driver_data']['driver_mobile'],
                    'lat' => $tracking_data['latitude'],
                    'lng' => $tracking_data['longitude'],
                );

                // 已停留时间
                $value['stay_time'] = get_stay_time($value['order_data']['order_end_time']);
             }
        }

        $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'order_end_time', SORT_DESC);

        $this->data['js_lat_lng'] = json_encode($this->data['js_lat_lng']);

        $this->data['links'] = $this->pagination->create_links();

        $this->data['cur_page_num'] = ceil($cur_num / $per_page) == 0 ? 1 : ceil($cur_num / $per_page) + 1;
        $this->data['total_page_num'] = ceil($this->data['total'] / $per_page);

        $this->load->view($this->appfolder.'/vehicle/sleep_vehicle_view', $this->data);
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

        echo json_encode($error);
        exit;
    }
}