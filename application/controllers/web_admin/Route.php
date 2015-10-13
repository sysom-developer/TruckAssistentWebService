<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Route extends Admin_Controller {

    public function index()
    {
        $this->set_path('线路列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('route', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/route/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('route', $where, $per_page, $cur_num, 'route_id', 'ASC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {

            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/route/route_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加线路');

        $where = array(
            'parent_id' => 1,
        );
        $this->data['get_region_options'] = $this->region_service->get_region_options(0, $where);
        
        $this->load->view(''.$this->appfolder.'/route/add_route_view', $this->data);
    }
    
    public function act_add_data()
    {
        $start_province_id = $this->input->post('start_province_id');
        $start_city_id = $this->input->post('start_city_id');
        $end_province_id = $this->input->post('end_province_id');
        $end_city_id = $this->input->post('end_city_id');
        $route_points = $this->input->post('route_points');
        $route_duration = trim($this->input->post('route_duration'));
        $route_status = $this->input->post('route_status');

        if (!(is_numeric($route_duration) && $route_duration > 0)) {
            show_error('请正确填写默认行驶预估时间，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        $route_duration = $route_duration * 3600;

        $start_province_data = $this->region_service->get_region_by_id($start_province_id);
        $start_city_data = $this->region_service->get_region_by_id($start_city_id);
        $end_province_data = $this->region_service->get_region_by_id($end_province_id);
        $end_city_data = $this->region_service->get_region_by_id($end_city_id);

        $start_region_name = $start_province_data['region_name'].$start_city_data['region_name'];
        $end_region_name = $end_province_data['region_name'].$end_city_data['region_name'];
        if ($start_province_data['region_name'] == $start_city_data['region_name']) {
            $start_region_name = $start_city_data['region_name'];
        }
        if ($end_province_data['region_name'] == $end_city_data['region_name']) {
            $end_region_name = $end_city_data['region_name'];
        }
        $route_name = $start_region_name.'-'.$end_region_name;

        $this->common_model->trans_begin();

        $time = date("Y-m-d H:i:s", time());

        $data = array(
            'start_province_id' => $start_province_id,
            'start_city_id' => $start_city_id,
            'end_province_id' => $end_province_id,
            'end_city_id' => $end_city_id,
            'route_points' => $route_points,
            'route_name' => $route_name,
            'route_duration' => $route_duration,
            'route_status' => $route_status,
            'route_time' => $time,
        );
        $insert_id = $this->common_model->insert('route', $data);

        // 插入日志
        $log_remark = '新增线路，线路ID：<a href="'.site_url(''.$this->appfolder.'/route/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(210, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/route');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑线路');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'route_id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('route', $where)->row_array();

        // 开始省
        $where = array(
            'parent_id' => 1,
        );
        $this->data['get_start_province_options'] = $this->region_service->get_region_options($this->data['data']['start_province_id'], $where);
        // 开始市
        $where = array(
            'parent_id' => $this->data['data']['start_province_id'],
        );
        $this->data['get_start_city_options'] = $this->region_service->get_region_options($this->data['data']['start_city_id'], $where);

        // 结束省
        $where = array(
            'parent_id' => 1,
        );
        $this->data['get_end_province_options'] = $this->region_service->get_region_options($this->data['data']['end_province_id'], $where);
        // 结束市
        $where = array(
            'parent_id' => $this->data['data']['end_province_id'],
        );
        $this->data['get_end_city_options'] = $this->region_service->get_region_options($this->data['data']['end_city_id'], $where);
        
        $this->load->view(''.$this->appfolder.'/route/edit_route_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $start_province_id = $this->input->post('start_province_id');
        $start_city_id = $this->input->post('start_city_id');
        $end_province_id = $this->input->post('end_province_id');
        $end_city_id = $this->input->post('end_city_id');
        $route_points = $this->input->post('route_points');
        $route_duration = trim($this->input->post('route_duration'));
        $route_status = $this->input->post('route_status');

        if (!(is_numeric($route_duration) && $route_duration > 0)) {
            show_error('请正确填写默认行驶预估时间，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        $route_duration = $route_duration * 3600;

        $start_province_data = $this->region_service->get_region_by_id($start_province_id);
        $start_city_data = $this->region_service->get_region_by_id($start_city_id);
        $end_province_data = $this->region_service->get_region_by_id($end_province_id);
        $end_city_data = $this->region_service->get_region_by_id($end_city_id);

        $start_region_name = $start_province_data['region_name'].$start_city_data['region_name'];
        $end_region_name = $end_province_data['region_name'].$end_city_data['region_name'];
        if ($start_province_data['region_name'] == $start_city_data['region_name']) {
            $start_region_name = $start_city_data['region_name'];
        }
        if ($end_province_data['region_name'] == $end_city_data['region_name']) {
            $end_region_name = $end_city_data['region_name'];
        }
        $route_name = $start_region_name.'-'.$end_region_name;

        $this->common_model->trans_begin();

        $time = date("Y-m-d H:i:s", time());

        $data = array(
            'start_province_id' => $start_province_id,
            'start_city_id' => $start_city_id,
            'end_province_id' => $end_province_id,
            'end_city_id' => $end_city_id,
            'route_points' => $route_points,
            'route_name' => $route_name,
            'route_duration' => $route_duration,
            'route_status' => $route_status,
            'route_time' => $time,
        );
        $where = array(
            'route_id' => $id,
        );
        $this->common_model->update('route', $data, $where);

        // 插入日志
        $log_remark = '编辑线路，线路ID：<a href="'.site_url(''.$this->appfolder.'/route/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(211, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/route');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();

        $data = array(
            'route_status' => 2,
        );
        $where = array(
            'route_id' => $id,
        );
        $this->common_model->update('route', $data, $where);

        // 插入日志
        $log_remark = '删除线路，线路ID：<a href="'.site_url(''.$this->appfolder.'/route/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(212, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/route');
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
}

?>