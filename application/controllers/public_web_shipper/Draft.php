<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Draft extends Public_MY_Controller {

    public function index()
    {
        $this->data['title'] = '草稿箱';

        // 更新草稿箱运单查看状态
        $affected_rows = $this->orders_service->update_draft_orders_status();

        // 货运公司货车数
        $shipper_driver_count_data = $this->shipper_driver_service->get_shipper_driver_count($this->shipper_info);

        $this->data['k'] = $this->input->get('k', TRUE);
        $this->data['k'] = $this->data['k'] ? $this->data['k'] : '';
        // 搜索字段非空
        if (!empty($this->data['k'])) {
            $where = array(
                'driver_name LIKE' => '%'.$this->data['k'].'%',
            );
            $search_driver_data_list = $this->driver_service->get_driver_data_list($where);
            if ($search_driver_data_list) {
                $search_driver_ids = array();
                foreach ($search_driver_data_list as $value) {
                    $search_driver_ids[] = $value['driver_id'];
                }

                $shipper_driver_count_data['driver_ids'] = $search_driver_ids;
            }
        }

        $per_page = 8;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $where = array(
            'driver_id' => $shipper_driver_count_data['driver_ids'],
            'order_type' => 1,
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
            foreach ($this->data['data_list'] as &$value) {
                // 司机信息
                $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);

                // 车辆信息
                $value['vehicle_data'] = $this->vehicle_service->get_vehicle_by_id($value['vehicle_id']);
                
                // 车辆类型信息
                $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);
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

        $this->load->view($this->appfolder.'/order/draft_view', $this->data);
    }

    public function ajax_delete_order()
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
            'order_status' => 2,
        );
        $where = array(
            'order_id' => $order_id,
        );
        $this->common_model->update('orders', $data, $where);

        echo json_encode($error);
        exit;
    }
}