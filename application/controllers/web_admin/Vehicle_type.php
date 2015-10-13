<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle_type extends Admin_Controller {

    public function index()
    {
        $this->set_path('车辆类型列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('vehicle_type', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/vehicle_type/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('vehicle_type', $where, $per_page, $cur_num, 'type_id', 'DESC')->result_array();

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/vehicle/vehicle_type_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加车辆类型');
        
        $this->load->view(''.$this->appfolder.'/vehicle/add_vehicle_type_view', $this->data);
    }
    
    public function act_add_data()
    {
        $type_name = trim($this->input->post('type_name'));
        $status = $this->input->post('status');

        if (empty($type_name)) {
            show_error('请输入车辆类型，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'type_name' => $type_name,
            'type_status' => $type_status,
            'create_time' => date("Y-m-d H:i:s", $time),
        );
        $insert_id = $this->common_model->insert('vehicle_type', $data);

        // 插入日志
        $log_remark = '新增车辆类型，车辆类型ID：<a href="'.site_url(''.$this->appfolder.'/vehicle_type/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(320, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/vehicle_type');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑车辆类型');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'type_id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('vehicle_type', $where)->row_array();
        
        $this->load->view(''.$this->appfolder.'/vehicle/edit_vehicle_type_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $type_name = trim($this->input->post('type_name'));
        $type_status = $this->input->post('type_status');

        if (empty($type_name)) {
            show_error('请输入车辆类型，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'type_name' => $type_name,
            'type_status' => $type_status,
        );
        $where = array(
            'type_id' => $id,
        );
        $this->common_model->update('vehicle_type', $data, $where);

        // 插入日志
        $log_remark = '编辑车辆类型，车辆类型ID：<a href="'.site_url(''.$this->appfolder.'/vehicle_type/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(321, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/vehicle_type');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();
        
        $where = array(
            'type_id' => $id,
        );
        $this->common_model->delete('vehicle_type', $where);

        // 插入日志
        $log_remark = '删除车辆类型，车辆类型ID：<a href="'.site_url(''.$this->appfolder.'/vehicle_type/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(322, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/vehicle_type');
    }
}

?>