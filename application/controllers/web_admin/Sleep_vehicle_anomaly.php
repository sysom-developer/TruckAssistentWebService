<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sleep_vehicle_anomaly extends Admin_Controller {

    public function index()
    {
        $this->set_path('可用车辆异常列表');

        $per_page = 16;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $where = array();
        $driver_data_list = $this->driver_service->get_driver_data_list($where);

        $driver_ids = array();
        foreach ($driver_data_list as $value) {
            $where = array(
                'driver_id' => $value['driver_id'],
                'order_type' => array(4),
            );
            $order_data_list = $this->orders_service->get_orders_data_list($where);
            if (empty($order_data_list)) {
                $driver_ids[$value['driver_id']] = $value['driver_id'];
            }
        }

        $sleep_driver_ids = array();
        if (!empty($driver_ids)) {
            $where = array(
                'driver_id' => $driver_ids,
            );
            $data_list = $this->vehicle_service->get_vehicle_data_list($where);
            if ($data_list) {
                foreach ($data_list as $vehicle_data) {
                    if (in_array($vehicle_data['driver_id'], $driver_ids)) {
                        $sleep_driver_ids[$vehicle_data['driver_id']] = $vehicle_data['driver_id'];
                    }
                }
            }
        }

        $this->data['data_list'] = array();
        $this->data['links'] = '';
        if (!empty($sleep_driver_ids)) {
            $where = array(
                'driver_id' => $sleep_driver_ids,
            );

            // 组合搜索条件
            $search_str = '?1=1';
            $this->data['driver_name'] = $this->input->get('driver_name');
            if (!empty($this->data['driver_name'])) {
                $where['driver_name LIKE'] = '%'.$this->data['driver_name'].'%';
                $search_str .= '&driver_name='.$this->data['driver_name'];
            }

            $this->data['driver_mobile'] = $this->input->get('driver_mobile');
            if (!empty($this->data['driver_mobile'])) {
                $where['driver_mobile LIKE'] = '%'.$this->data['driver_mobile'].'%';
                $search_str .= '&driver_mobile='.$this->data['driver_mobile'];
            }

            $this->data['company_id'] = $this->input->get('company_id');
            $this->data['company_id'] = $this->data['company_id'] ? $this->data['company_id'] : 0;
            $s_where = array(
                'shipper_company_id' => $this->data['company_id'],
            );
            $shipper_driver_data_list = $this->shipper_driver_service->get_shipper_driver_data_list($s_where);
            $s_driver_ids = array();
            if ($shipper_driver_data_list) {
                foreach ($shipper_driver_data_list as $value) {
                    $s_driver_ids[] = $value['driver_id'];
                }
                $where['driver_id'] = $s_driver_ids;
                $search_str .= '&company_id='.$this->data['company_id'];
            }

            $this->data['total'] = $this->common_model->get_count('driver', $where);
            
            // 分页初始化
            $page_config = array();
            $page_config['display_pages'] = FALSE;
            $page_config['page_query_string'] = TRUE;
            $page_config['base_url'] = site_url(''.$this->appfolder.'/sleep_vehicle_anomaly/index/'.$search_str);
            $page_config['total_rows'] = $this->data['total'];
            $page_config['per_page'] = $per_page;
            $page_config['first_link'] = '第一页';
            $page_config['last_link'] = '最后一页';
            $page_config['prev_link'] = '上一页';
            $page_config['next_link'] = '下一页';
            $this->pagination->initialize($page_config);
            
            $this->data['data_list'] = $this->common_model->get_data('driver', $where, $per_page, $cur_num, 'driver_id', 'DESC')->result_array();
            if ($this->data['data_list']) {
                foreach ($this->data['data_list'] as &$value) {
                    // 上次运单路线和完成时间
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'order_type' => 5,
                    );
                    $value['last_finished_order_data'] = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');

                    // 所在公司
                    $where = array(
                        'driver_id' => $value['driver_id'],
                    );
                    $shipper_driver_data_list = $this->shipper_driver_service->get_shipper_driver_data_list($where);
                    $value['driver_company_data_list'] = '';
                    if (!empty($shipper_driver_data_list)) {
                        foreach ($shipper_driver_data_list as $value2) {
                            $shipper_company_data = $this->shipper_company_service->get_shipper_company_by_id($value2['shipper_company_id']);
                            $value['driver_company_data_list'] .= $shipper_company_data['shipper_company_name'].'<br />';
                        }
                    }

                    $where = array(
                        'driver_id' => $value['driver_id'],
                    );
                    $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');

                    // 当前位置信息
                    $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                    $value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                    $value['unix_time'] = strtotime($tracking_data['create_time']);
                    if ($value['unix_time'] === FALSE) {
                        $value['unix_time'] = 9999999999;
                    }
                    $value['unix_time'] += 3600;

                    if (empty($tracking_data)) {
                        $value['anomaly_desc'] = '未上传位置信息';
                    } else {
                        $value['anomaly_desc'] = get_stay_time($value['unix_time']).' 未上传';
                    }
                }
                $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'unix_time', SORT_ASC);
            }

            $this->data['links'] = $this->pagination->create_links();
        }

        $this->data['shipper_company_options'] = $this->shipper_company_service->get_shipper_company_options($this->data['company_id']);
        
        $this->load->view(''.$this->appfolder.'/vehicle/sleep_vehicle_anomaly_view', $this->data);
    }
}

?>