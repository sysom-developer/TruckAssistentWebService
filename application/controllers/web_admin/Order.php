<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        // 运单状态
        $this->data['order_type_desc'] = $this->config->item('order_type_desc');
    }

    public function index()
    {
        $this->set_path('运单列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $where = array();

        // 组合搜索条件
        $search_str = '?1=1';

        $this->data['order_num'] = $this->input->get('order_num');
        if (!empty($this->data['order_num'])) {
            $where['order_num LIKE'] = '%'.$this->data['order_num'].'%';
            $search_str .= '&order_num='.$this->data['order_num'];
        }

        $this->data['driver_name'] = $this->input->get('driver_name');
        if (!empty($this->data['driver_name'])) {
            $s_where = array();
            $s_where['driver_name LIKE'] = '%'.$this->data['driver_name'].'%';
            $driver_data_list = $this->driver_service->get_driver_data_list($s_where);
            if ($driver_data_list) {
                $driver_ids = array();
                foreach ($driver_data_list as $value) {
                    $driver_ids[] = $value['driver_id'];
                }
                $where['driver_id'] = $driver_ids;
            }

            $search_str .= '&driver_name='.$this->data['driver_name'];
        }

        $this->data['start_time'] = $this->input->get('start_time');
        if (!empty($this->data['start_time'])) {
            $where['good_start_time >='] = strtotime($this->data['start_time']." 00:00:00");
            $search_str .= '&start_time='.$this->data['start_time'];
        }

        $this->data['end_time'] = $this->input->get('end_time');
        if (!empty($this->data['end_time'])) {
            $where['good_start_time <='] = strtotime($this->data['end_time']." 23:59:59");
            $search_str .= '&end_time='.$this->data['end_time'];
        }

        $this->data['order_type'] = $this->input->get('order_type');
        if (!empty($this->data['order_type'])) {
            $where['order_type'] = $this->data['order_type'];
            $search_str .= '&order_type='.$this->data['order_type'];
        }

        $this->data['order_status'] = $this->input->get('order_status');
        if (!empty($this->data['order_status'])) {
            $where['order_status'] = $this->data['order_status'];
            $search_str .= '&order_status='.$this->data['order_status'];
        } else {
            $this->data['order_status'] = 1;
            $where['order_status'] = 1;
        }
        
        $this->data['total'] = $this->common_model->get_count('orders', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['display_pages'] = FALSE;
        $page_config['page_query_string'] = TRUE;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/order/index/'.$search_str);
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('orders', $where, $per_page, $cur_num, 'order_id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            $time = time();
            foreach ($this->data['data_list'] as &$value) {
                // 司机信息
                $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);

                // 车辆信息
                $value['vehicle_data'] = $this->vehicle_service->get_vehicle_by_id($value['vehicle_id']);

                // 车辆类型信息
                $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                // 运行时间
                $value['exec_time'] = '-';
                if ($this->data['order_type'] == 3) {   // 已接
                    $exec_time = $value['good_start_time'] - $time;
                    $value['exec_time'] = get_stay_time($exec_time, 1, 1, 0);
                } elseif ($this->data['order_type'] == 4) {   // 在途
                    $exec_time = $time - $value['good_start_time'];
                    $value['exec_time'] = get_stay_time($exec_time, 1, 1, 0);
                }

                // 当前位置信息
                $where = array(
                    'driver_id' => $value['driver_id'],
                    'vehicle_id' => $value['vehicle_id'],
                );
                $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');
                $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                $value['current_location'] = $current_location.' '.($tracking_data['create_time'] ? date('m-d H:i', strtotime($tracking_data['create_time'])) : '');
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/order/order_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加运单');

        $company_id = $this->input->get('company_id');

        $where = array();
        $shipper_company_data = $this->shipper_company_service->get_shipper_company_data($where, 1, 0, 'id', 'ASC');
        if (!empty($company_id)) {
            $shipper_company_data = $this->shipper_company_service->get_shipper_company_by_id($company_id);
        }
        $shipper_company_id = $shipper_company_data['id'];

        // 货运公司 option 选项
        $this->data['shipper_company_option'] = $this->shipper_company_service->get_shipper_company_options($shipper_company_id);

        // 货主 option 选项
        $where = array(
            'company_id' => $shipper_company_id,
        );
        $this->data['shipper_option'] = $this->shipper_service->get_shipper_options($where);

        // 指定货车
        $where = array(
            'shipper_company_id' => $shipper_company_id,
        );
        $this->data['shipper_driver_option'] = $this->vehicle_service->get_current_shipper_driver_vehicle_options(0, $where);

        if ($shipper_company_data['is_special'] == 1) {
            // 货运线路
            $where = array(
                'shipper_company_id' => $shipper_company_id,
            );
            $this->data['shipper_route_option'] = $this->shipper_route_service->get_shipper_route_options($where);

            $this->load->view(''.$this->appfolder.'/order/add_special_order_view', $this->data);
        } elseif ($shipper_company_data['is_special'] == 2) {
            // 货物类型
            $this->data['goods_category_option'] = $this->goods_category_service->get_goods_category_options();

            // 出发地省份
            $where = array(
                'parent_id' => 1,
            );
            $this->data['get_region_options'] = $this->region_service->get_region_options(0, $where);

            $this->load->view(''.$this->appfolder.'/order/add_normal_order_view', $this->data);
        }
    }
    
    public function ajax_do_normal_order()
    {
        $error = array(
            'code' => 'success',
        );

        $shipper_id = $this->input->post('shipper_id', TRUE);
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

        $order_num = get_order_sn($shipper_id);

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
            'shipper_id' => $shipper_id,
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
            'release_id' => $shipper_id,
            'order_type' => $order_type,
            'create_time' => $time,
            'driver_id' => $vehicle_data['driver_id'],
            'vehicle_id' => $vehicle_id,
            'order_num' => $order_num,
            'start_location_lat' => $start_location_lat,
            'start_location_lng' => $start_location_lng,
            'end_location_lat' => $end_location_lat,
            'end_location_lng' => $end_location_lng,
            'cre_from' => 3,
        );

        $order_id = $this->common_model->insert('orders', $data);

        // 写入 order_log 日志
        for ($i=2; $i <= $order_type; $i++) {
            if ($i == 2) {
                $des = '客服操作 - 待接';
            } elseif ($i == 3) {
                $des = '客服操作 - 已接';
            } elseif ($i == 4) {
                $des = '客服操作 - 发车';
            } elseif ($i == 5) {
                $des = '客服操作 - 完成';
            }

            $where = array(
                'order_id' => $order_id,
                'driver_id' => $vehicle_data['driver_id'],
                'vehicle_id' => $vehicle_id,
                'order_type' => $i,
            );
            $order_log_data = $this->order_log_service->get_order_log_data($where);
            if (empty($order_log_data)) {
                $data = array(
                    'order_id' => $order_id,
                    'driver_id' => $vehicle_data['driver_id'],
                    'vehicle_id' => $vehicle_id,
                    'order_type' => $i,
                    'opereation_id' => $vehicle_data['driver_id'],
                    'create_time' => date('Y-m-d H:i:s', $good_start_time + ($i - 1)),
                    'des' => $des,
                );
                $this->common_model->insert('order_log', $data);
            }
        }

        // 插入日志
        $log_remark = '新增一般运单，运单ID：<a href="'.site_url(''.$this->appfolder.'/order/edit_data/'.$order_id.'').'">'.$order_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(110, $log_remark, $this->user_info['id']);

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

    public function ajax_do_special_order()
    {
        $error = array(
            'code' => 'success',
        );

        $shipper_id = $this->input->post('shipper_id', TRUE);
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
        $order_num = get_order_sn($shipper_id);

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

        $where = array(
            'shipper_id' => $shipper_id
        );
        $shipper_company_data = $this->shipper_service->get_shipper_by_id($where);

        // 货运公司专线信息
        $where = array(
            'shipper_company_id' => $shipper_company_data['company_id'],
            'route_id' => $route_id,
        );
        $shipper_route_data = $this->shipper_route_service->get_shipper_route_data($where);

        // 车辆所属司机信息
        $vehicle_data = $this->vehicle_service->get_vehicle_by_id($vehicle_id);

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'shipper_id' => $shipper_company_data['shipper_id'],
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
            'release_id' => $shipper_company_data['shipper_id'],
            'order_type' => $order_type,
            'create_time' => $time,
            'driver_id' => $vehicle_data['driver_id'],
            'vehicle_id' => $vehicle_id,
            'order_num' => $order_num,
            'start_location_lat' => $start_location_lat,
            'start_location_lng' => $start_location_lng,
            'end_location_lat' => $end_location_lat,
            'end_location_lng' => $end_location_lng,
            'cre_from' => 3,
        );

        $order_id = $this->common_model->insert('orders', $data);

        // 写入 order_log 日志
        for ($i=2; $i <= $order_type; $i++) {
            if ($i == 2) {
                $des = '客服操作 - 待接';
            } elseif ($i == 3) {
                $des = '客服操作 - 已接';
            } elseif ($i == 4) {
                $des = '客服操作 - 发车';
            } elseif ($i == 5) {
                $des = '客服操作 - 完成';
            }

            $where = array(
                'order_id' => $order_id,
                'driver_id' => $vehicle_data['driver_id'],
                'vehicle_id' => $vehicle_id,
                'order_type' => $i,
            );
            $order_log_data = $this->order_log_service->get_order_log_data($where);
            if (empty($order_log_data)) {
                $data = array(
                    'order_id' => $order_id,
                    'driver_id' => $vehicle_data['driver_id'],
                    'vehicle_id' => $vehicle_id,
                    'order_type' => $i,
                    'opereation_id' => $vehicle_data['driver_id'],
                    'create_time' => date('Y-m-d H:i:s', $good_start_time + ($i - 1)),
                    'des' => $des,
                );
                $this->common_model->insert('order_log', $data);
            }
        }

        // 插入日志
        $log_remark = '新增专线运单，运单ID：<a href="'.site_url(''.$this->appfolder.'/order/edit_data/'.$order_id.'').'">'.$order_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(110, $log_remark, $this->user_info['id']);

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
    
    public function edit_data()
    {
        $this->set_path('编辑运单');
        
        $this->data['id'] = $this->input->get('id');
        
        // 运单数据
        $where = array(
            'order_id' => $this->data['id'],
        );
        $this->data['order_data'] = $this->common_model->get_data('orders', $where)->row_array();

        // 货主数据
        $where = array(
            'shipper_id' => $this->data['order_data']['shipper_id'],
        );
        $this->data['shipper_data'] = $this->common_model->get_data('shipper', $where)->row_array();

        // 货运公司数据
        $shipper_company_data = $this->shipper_company_service->get_shipper_company_by_id($this->data['shipper_data']['company_id']);
        $shipper_company_id = $shipper_company_data['id'];

        // 货运公司 option 选项
        $this->data['shipper_company_option'] = $this->shipper_company_service->get_shipper_company_options($shipper_company_id);

        // 货主 option 选项
        $where = array(
            'company_id' => $shipper_company_id,
        );
        $this->data['shipper_option'] = $this->shipper_service->get_shipper_options($where);

        // 指定货车
        $where = array(
            'shipper_company_id' => $shipper_company_id,
        );
        $this->data['shipper_driver_option'] = $this->vehicle_service->get_current_shipper_driver_vehicle_options($this->data['order_data']['vehicle_id'], $where);

        // 货物类型
        $this->data['goods_category_option'] = $this->goods_category_service->get_goods_category_options($this->data['order_data']['good_category']);

        // 出发地省份
        $where = array(
            'parent_id' => 1,
        );
        $this->data['start_region_options'] = $this->region_service->get_region_options($this->data['order_data']['start_province_id'], $where);
        // 出发地市
        $where = array(
            'parent_id' => $this->data['order_data']['start_province_id'],
        );
        $this->data['start_city_options'] = $this->region_service->get_region_options($this->data['order_data']['start_city_id'], $where);

        // 目的地省份
        $where = array(
            'parent_id' => 1,
        );
        $this->data['end_region_options'] = $this->region_service->get_region_options($this->data['order_data']['end_province_id'], $where);
        // 目的地市
        $where = array(
            'parent_id' => $this->data['order_data']['end_province_id'],
        );
        $this->data['end_city_options'] = $this->region_service->get_region_options($this->data['order_data']['end_city_id'], $where);

        if ($shipper_company_data['is_special'] == 1) {
            $this->load->view(''.$this->appfolder.'/order/edit_special_order_view', $this->data);
        } elseif ($shipper_company_data['is_special'] == 2) {
            $this->load->view(''.$this->appfolder.'/order/edit_normal_order_view', $this->data);
        }
    }

    public function ajax_edit_change_data()
    {
        $error = array(
            'code' => 'success',
        );

        $shipper_company_id = $this->input->post('company_id');

        // 货主 option 选项
        $where = array(
            'company_id' => $shipper_company_id,
        );
        $error['shipper_option'] = $this->shipper_service->get_shipper_options($where);

        // 指定货车
        $where = array(
            'shipper_company_id' => $shipper_company_id,
        );
        $error['shipper_driver_option'] = $this->vehicle_service->get_current_shipper_driver_vehicle_options(0, $where);

        echo json_encode($error);
        exit;
    }
    
    public function ajax_edit_do_normal_order()
    {
        $error = array(
            'code' => 'success',
        );

        $id = $this->input->post('id');

        $shipper_id = $this->input->post('shipper_id', TRUE);
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

        // if (!(is_numeric($good_margin) && $good_margin > 0)) {
        //     $error['code'] = '请正确填写保证金，如：100000';
        //     echo json_encode($error);
        //     exit;
        // }

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

        if ($order_type == 5) {
            // 增加积分 - 司机是否是第一单
            $this->shipper_company_service->driver_first_finished_order($vehicle_data['driver_id'], $id);
        }

        $time = time();

        $data = array(
            'shipper_id' => $shipper_id,
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
            'release_id' => $shipper_id,
            'order_type' => $order_type,
            'driver_id' => $vehicle_data['driver_id'],
            'vehicle_id' => $vehicle_id,
            'start_location_lat' => $start_location_lat,
            'start_location_lng' => $start_location_lng,
            'end_location_lat' => $end_location_lat,
            'end_location_lng' => $end_location_lng,
        );
        $where = array(
            'order_id' => $id,
        );

        $order_id = $this->common_model->update('orders', $data, $where);

        $where = array(
            'order_id' => $id,
        );
        $order_log_data_list = $this->order_log_service->get_order_log_data_list($where, '', '', 'log_id', 'ASC');
        $j = 2;
        if ($order_log_data_list) {
            foreach ($order_log_data_list as $value) {
                // 写入 order_log 日志
                if ($value['order_type'] == 2) {
                    $j = 2;
                } elseif ($value['order_type'] == 3) {
                    $j = 3;
                } elseif ($value['order_type'] == 4) {
                    $j = 4;
                } elseif ($value['order_type'] == 5) {
                    $j = 5;
                }
            }
        }

        // 写入 order_log 日志
        for ($i=2; $i <= $order_type; $i++) {
            if ($i == 2) {
                $des = '客服操作 - 待接';
            } elseif ($i == 3) {
                $des = '客服操作 - 已接';
            } elseif ($i == 4) {
                $des = '客服操作 - 发车';
            } elseif ($i == 5) {
                $des = '客服操作 - 完成';
            }

            $where = array(
                'order_id' => $id,
                'driver_id' => $vehicle_data['driver_id'],
                'vehicle_id' => $vehicle_data['vehicle_id'],
                'order_type' => $i,
            );
            $order_log_data = $this->order_log_service->get_order_log_data($where);
            if (empty($order_log_data)) {
                $data = array(
                    'order_id' => $id,
                    'driver_id' => $vehicle_data['driver_id'],
                    'vehicle_id' => $vehicle_data['vehicle_id'],
                    'order_type' => $i,
                    'opereation_id' => $vehicle_data['driver_id'],
                    'create_time' => date('Y-m-d H:i:s', $good_start_time + ($i - 1)),
                    'des' => $des,
                );
                $this->common_model->insert('order_log', $data);
            }
        }

        // 插入日志
        $log_remark = '编辑运单，运单ID：<a href="'.site_url(''.$this->appfolder.'/order/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(111, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

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
    
    public function delete()
    {
        $id = $this->input->get('id');

        $this->common_model->trans_begin();
        
        $data = array(
            'order_status' => 2,
        );
        $where = array(
            'order_id' => $id,
        );
        $this->common_model->update('orders', $data, $where);

        // 插入日志
        $log_remark = '删除运单，运单ID：<a href="'.site_url(''.$this->appfolder.'/order/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(112, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/order');
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
                    'address_data' => '（'.$value['name'].'）'.$value['address'],
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
                    'address_data' => '（'.$value['name'].'）'.$value['address'],
                );
            }
        }

        $error['address_list'] = $address_list;
        echo json_encode($error);
        exit;
    }
}

?>