<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finished_order_not_ok_anomaly extends Admin_Controller {

    public function index()
    {
        $this->set_path('完成未确认异常列表');

        $per_page = 16;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $time = time();

        $where = array(
            'good_end_time <' => $time,
            'order_type' => array(2, 3, 4),
            'order_status' => 1,
        );

        // 组合搜索条件
        $search_str = '?1=1';

        $this->data['company_id'] = $this->input->get('company_id');
        $this->data['company_id'] = $this->data['company_id'] ? $this->data['company_id'] : 0;
        $s_where = array(
            'company_id' => $this->data['company_id'],
        );
        $shipper_data_list = $this->shipper_service->get_shipper_data_list($s_where);
        if ($shipper_data_list) {
            $s_shipper_ids = array();
            foreach ($shipper_data_list as $value) {
                $s_shipper_ids[] = $value['shipper_id'];
            }
            $where['shipper_id'] = $s_shipper_ids;
            $search_str .= '&company_id='.$this->data['company_id'];
        }

        $this->data['total'] = $this->common_model->get_count('orders', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['display_pages'] = FALSE;
        $page_config['page_query_string'] = TRUE;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/finished_order_not_ok_anomaly/index/'.$search_str);
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('orders', $where, $per_page, $cur_num, 'driver_id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                // 司机信息
                $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);

                // 运单公司
                $shipper_data = $this->shipper_service->get_shipper_by_id($value['shipper_id']);
                $value['shipper_company_data'] = $this->shipper_company_service->get_shipper_company_by_id($shipper_data['company_id']);

                $where = array(
                    'driver_id' => $value['driver_id'],
                );
                $tracking_data = $this->tracking_service->get_tracking_data($where, 1, 0, 'id', 'DESC');

                // 当前位置信息
                $current_location = get_location_by_lat_lng($tracking_data['latitude'], $tracking_data['longitude']);
                $value['current_location'] = $current_location.' '.date('m-d H:i', strtotime($tracking_data['create_time']));

                $value['anomaly_desc'] = get_stay_time($value['good_end_time']).' 未确认';
            }
            $this->data['data_list'] = multi_array_sort($this->data['data_list'], 'good_end_time', SORT_ASC);
        }

        $this->data['links'] = $this->pagination->create_links();

        $this->data['shipper_company_options'] = $this->shipper_company_service->get_shipper_company_options($this->data['company_id']);
        
        $this->load->view(''.$this->appfolder.'/vehicle/finished_order_not_ok_anomaly_view', $this->data);
    }
}

?>