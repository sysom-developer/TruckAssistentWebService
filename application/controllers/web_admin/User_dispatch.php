<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_dispatch extends Admin_Controller {

    public function index()
    {
        $this->set_path('调度角色列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('user_dispatch', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/user_dispatch/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('user_dispatch', $where, $per_page, $cur_num, 'id', 'DESC')->result_array();

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/user_dispatch/user_dispatch_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加调度角色');
        
        $this->load->view(''.$this->appfolder.'/user_dispatch/add_user_dispatch_view', $this->data);
    }
    
    public function act_add_data()
    {
        $username = trim($this->input->post('username'));
        $mobile_phone = $this->input->post('mobile_phone');
        $status = $this->input->post('status');

        // 验证手机号码
        if (empty($username)) {
            show_error('请输入调度名称，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        // 验证手机号码
        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            show_error('请正确输入手机号码，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'username' => $username,
            'mobile_phone' => $mobile_phone,
            'status' => $status,
            'cretime' => $time,
            'updatetime' => $time,
        );
        $insert_id = $this->common_model->insert('user_dispatch', $data);

        // 插入日志
        $log_remark = '新增调度角色，调度角色ID：<a href="'.site_url(''.$this->appfolder.'/user_dispatch/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(100, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/user_dispatch');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑调度角色');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('user_dispatch', $where)->row_array();
        
        $this->load->view(''.$this->appfolder.'/user_dispatch/edit_user_dispatch_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $username = trim($this->input->post('username'));
        $mobile_phone = $this->input->post('mobile_phone');
        $status = $this->input->post('status');

        // 验证手机号码
        if (empty($username)) {
            show_error('请输入调度名称，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        // 验证手机号码
        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            show_error('请正确输入手机号码，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'username' => $username,
            'mobile_phone' => $mobile_phone,
            'status' => $status,
            'updatetime' => $time,
        );
        $where = array(
            'id' => $id,
        );
        $this->common_model->update('user_dispatch', $data, $where);

        // 插入日志
        $log_remark = '编辑调度角色，调度角色ID：<a href="'.site_url(''.$this->appfolder.'/user_dispatch/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(101, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/user_dispatch');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();

        $data = array(
            'id' => 2,
        );
        $where = array(
            'id' => $id,
        );
        $this->common_model->update('user_dispatch', $data, $where);

        // 插入日志
        $log_remark = '删除调度角色，调度角色ID：<a href="'.site_url(''.$this->appfolder.'/user_dispatch/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(102, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/user_dispatch');
    }
}

?>