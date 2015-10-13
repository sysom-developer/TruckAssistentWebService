<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipper_route extends Admin_Controller {

    public function index()
    {
        $this->set_path('货运公司关联线路列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('shipper_route', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/shipper_route/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('shipper_route', $where, $per_page, $cur_num, 'id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                $value['shipper_company_data'] = $this->shipper_company_service->get_shipper_company_by_id($value['shipper_company_id']);

                $value['route_data'] = $this->route_service->get_route_by_id($value['route_id']);
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/shipper_route/shipper_route_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加货运公司关联线路');

        $this->data['get_shipper_company_options'] = $this->shipper_company_service->get_shipper_company_options();

        $this->data['get_route_options'] = $this->route_service->get_route_options();
        
        $this->load->view(''.$this->appfolder.'/shipper_route/add_shipper_route_view', $this->data);
    }
    
    public function act_add_data()
    {
        $shipper_company_id = $this->input->post('shipper_company_id');
        $route_id = $this->input->post('route_id');
        $shipper_company_tel = $this->input->post('shipper_company_tel');
        $shipper_route_freight = $this->input->post('shipper_route_freight');
        $shipper_route_margin = $this->input->post('shipper_route_margin');

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'shipper_company_id' => $shipper_company_id,
            'route_id' => $route_id,
            'shipper_company_tel' => $shipper_company_tel,
            'shipper_route_freight' => sprintf("%0.2f", $shipper_route_freight),
            'shipper_route_margin' => sprintf("%0.2f", $shipper_route_margin),
            'create_time' => date("Y-m-d H:i:s", $time),
        );
        $insert_id = $this->common_model->insert('shipper_route', $data);

        // 插入日志
        $log_remark = '新增货运公司关联线路，货运公司关联线路ID：<a href="'.site_url(''.$this->appfolder.'/shipper_route/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(200, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/shipper_route');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑货运公司关联线路');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('shipper_route', $where)->row_array();

        $this->data['get_shipper_company_options'] = $this->shipper_company_service->get_shipper_company_options($this->data['data']['shipper_company_id']);

        $this->data['get_route_options'] = $this->route_service->get_route_options($this->data['data']['route_id']);
        
        $this->load->view(''.$this->appfolder.'/shipper_route/edit_shipper_route_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $shipper_company_id = $this->input->post('shipper_company_id');
        $route_id = $this->input->post('route_id');
        $shipper_company_tel = $this->input->post('shipper_company_tel');
        $shipper_route_freight = $this->input->post('shipper_route_freight');
        $shipper_route_margin = $this->input->post('shipper_route_margin');

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'shipper_company_id' => $shipper_company_id,
            'route_id' => $route_id,
            'shipper_company_tel' => $shipper_company_tel,
            'shipper_route_freight' => sprintf("%0.2f", $shipper_route_freight),
            'shipper_route_margin' => sprintf("%0.2f", $shipper_route_margin),
        );
        $where = array(
            'id' => $id,
        );
        $this->common_model->update('shipper_route', $data, $where);

        // 插入日志
        $log_remark = '编辑货运公司关联线路，货运公司关联线路ID：<a href="'.site_url(''.$this->appfolder.'/shipper_route/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(201, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/shipper_route');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();
        
        $where = array(
            'id' => $id,
        );
        $this->common_model->delete('shipper_route', $where);

        // 插入日志
        $log_remark = '删除货运公司关联线路，货运公司关联线路ID：<a href="'.site_url(''.$this->appfolder.'/shipper_route/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(202, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/shipper_route');
    }
}

?>