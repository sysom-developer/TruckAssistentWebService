<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle_length extends Admin_Controller {

    public function index()
    {
        $this->set_path('车辆长度属性列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('vehicle_length', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/vehicle_length/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('vehicle_length', $where, $per_page, $cur_num, 'l_id', 'DESC')->result_array();

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/vehicle/vehicle_length_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加车辆长度属性');
        
        $this->load->view(''.$this->appfolder.'/vehicle/add_vehicle_length_view', $this->data);
    }
    
    public function act_add_data()
    {
        $length = trim($this->input->post('length'));
        $status = $this->input->post('status');

        if (empty($length)) {
            show_error('请输入车辆长度属性名称，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'length' => $length,
            'status' => $status,
            'create_time' => date("Y-m-d H:i:s", $time),
        );
        $insert_id = $this->common_model->insert('vehicle_length', $data);

        // 插入日志
        $log_remark = '新增车辆长度属性，车辆长度属性ID：<a href="'.site_url(''.$this->appfolder.'/vehicle_length/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(330, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/vehicle_length');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑车辆长度属性');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'l_id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('vehicle_length', $where)->row_array();
        
        $this->load->view(''.$this->appfolder.'/vehicle/edit_vehicle_length_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $length = trim($this->input->post('length'));
        $status = $this->input->post('status');

        if (empty($length)) {
            show_error('请输入车辆长度属性名称，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'length' => $length,
            'status' => $status,
        );
        $where = array(
            'l_id' => $id,
        );
        $this->common_model->update('vehicle_length', $data, $where);

        // 插入日志
        $log_remark = '编辑车辆长度属性，车辆长度属性ID：<a href="'.site_url(''.$this->appfolder.'/vehicle_length/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(331, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/vehicle_length');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();
        
        $where = array(
            'l_id' => $id,
        );
        $this->common_model->delete('vehicle_length', $where);

        // 插入日志
        $log_remark = '删除车辆长度属性，车辆长度属性ID：<a href="'.site_url(''.$this->appfolder.'/vehicle_length/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(332, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/vehicle_length');
    }
}

?>