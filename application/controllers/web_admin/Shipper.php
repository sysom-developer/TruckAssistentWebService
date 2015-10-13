<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipper extends Admin_Controller {

    public function index()
    {
        $this->set_path('货主列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('shipper', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/shipper/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('shipper', $where, $per_page, $cur_num, 'shipper_id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                $value['shipper_company_data'] = $this->shipper_company_service->get_shipper_company_by_id($value['company_id']);

                $attachment_data = $this->attachment_service->get_attachment_by_id($value['shipper_head_icon']);
                $value['shipper_head_icon_http_file'] = $attachment_data['http_file'];

                $attachment_data = $this->attachment_service->get_attachment_by_id($value['shipper_pic']);
                $value['shipper_pic_http_file'] = $attachment_data['http_file'];

                $attachment_data = $this->attachment_service->get_attachment_by_id($value['shipper_card_pic']);
                $value['shipper_card_pic_http_file'] = $attachment_data['http_file'];
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/shipper/shipper_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加货主');

        $this->data['shipper_company_data_list'] = $this->shipper_company_service->get_shipper_company_data_list();
        
        $this->load->view(''.$this->appfolder.'/shipper/add_shipper_view', $this->data);
    }
    
    public function act_add_data()
    {
        $company_id = trim($this->input->post('company_id'));
        $shipper_name = trim($this->input->post('shipper_name'));
        $login_name = trim($this->input->post('login_name'));
        $login_pwd = trim($this->input->post('login_pwd'));
        $shipper_mobile = $this->input->post('shipper_mobile');
        $shipper_card_num = $this->input->post('shipper_card_num');
        $shipper_type = $this->input->post('shipper_type');
        $is_admin = $this->input->post('is_admin');
        $shipper_head_icon_img_attachment_id = $this->input->post('shipper_head_icon_img_attachment_id');
        $shipper_pic_img_attachment_id = $this->input->post('shipper_pic_img_attachment_id');
        $shipper_card_pic_img_attachment_id = $this->input->post('shipper_card_pic_img_attachment_id');
        $shipper_status = $this->input->post('shipper_status');

        if (empty($shipper_name)) {
            show_error('请输入货主名称，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($login_name)) {
            show_error('请输入货主后台登陆用户名，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($login_pwd)) {
            show_error('请输入货主后台登陆密码，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        if ($is_admin == 1) {
            $where = array(
                'company_id' => $company_id,
                'is_admin' => $is_admin,
            );
            $count = $this->common_model->get_count('shipper', $where);
            if ($count > 0) {
                show_error('公司账户已经存在，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
            }
        }

        $this->common_model->trans_begin();

        $shipper_head_icon_attachment_id = '';
        if ($shipper_head_icon_img_attachment_id) {
            $shipper_head_icon_attachment_id = move_upload_file($shipper_head_icon_img_attachment_id);
        }

        $shipper_pic_attachment_id = '';
        if ($shipper_pic_img_attachment_id) {
            $shipper_pic_attachment_id = move_upload_file($shipper_pic_img_attachment_id);
        }

        $shipper_card_pic_attachment_id = '';
        if ($shipper_card_pic_img_attachment_id) {
            $shipper_card_pic_attachment_id = move_upload_file($shipper_card_pic_img_attachment_id);
        }

        $time = time();

        $data = array(
            'shipper_name' => $shipper_name,
            'login_name' => $login_name,
            'login_pwd' => $login_pwd,
            'shipper_mobile' => $shipper_mobile,
            'shipper_card_num' => $shipper_card_num,
            'shipper_type' => $shipper_type,
            'company_id' => $company_id,
            'is_admin' => $is_admin,
            'shipper_head_icon' => $shipper_head_icon_attachment_id,
            'shipper_pic' => $shipper_pic_attachment_id,
            'shipper_card_pic' => $shipper_card_pic_attachment_id,
            'shipper_status' => $shipper_status,
            'create_time' => date("Y-m-d H:i:s", $time),
        );
        $insert_id = $this->common_model->insert('shipper', $data);

        // 插入日志
        $log_remark = '新增货主，货主ID：<a href="'.site_url(''.$this->appfolder.'/shipper/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(500, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/shipper');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑货主');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'shipper_id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('shipper', $where)->row_array();

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['shipper_head_icon']);
        $this->data['data']['shipper_head_icon_http_file'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['shipper_pic']);
        $this->data['data']['shipper_pic_http_file'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['shipper_card_pic']);
        $this->data['data']['shipper_card_pic_http_file'] = $attachment_data['http_file'];

        $this->data['shipper_company_data_list'] = $this->shipper_company_service->get_shipper_company_data_list();
        
        $this->load->view(''.$this->appfolder.'/shipper/edit_shipper_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $company_id = trim($this->input->post('company_id'));
        $shipper_name = trim($this->input->post('shipper_name'));
        $login_name = trim($this->input->post('login_name'));
        $login_pwd = trim($this->input->post('login_pwd'));
        $shipper_mobile = $this->input->post('shipper_mobile');
        $shipper_card_num = $this->input->post('shipper_card_num');
        $shipper_type = $this->input->post('shipper_type');
        $is_admin = $this->input->post('is_admin');
        $shipper_head_icon_img_attachment_id = $this->input->post('shipper_head_icon_img_attachment_id');
        $shipper_pic_img_attachment_id = $this->input->post('shipper_pic_img_attachment_id');
        $shipper_card_pic_img_attachment_id = $this->input->post('shipper_card_pic_img_attachment_id');
        $shipper_status = $this->input->post('shipper_status');

        if (empty($shipper_name)) {
            show_error('请输入货主名称，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($login_name)) {
            show_error('请输入货主后台登陆用户名，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($login_pwd)) {
            show_error('请输入货主后台登陆密码，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        if ($is_admin == 1) {
            $where = array(
                'shipper_id !=' => $id,
                'company_id' => $company_id,
                'is_admin' => $is_admin,
            );
            $count = $this->common_model->get_count('shipper', $where);
            if ($count > 0) {
                show_error('公司账户已经存在，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
            }
        }

        $this->common_model->trans_begin();

        $where = array(
            'shipper_id' => $id,
        );
        $shipper_data = $this->common_model->get_data('shipper', $where)->row_array();

        $data = array(
            'shipper_name' => $shipper_name,
            'login_name' => $login_name,
            'login_pwd' => $login_pwd,
            'shipper_mobile' => $shipper_mobile,
            'shipper_card_num' => $shipper_card_num,
            'shipper_type' => $shipper_type,
            'company_id' => $company_id,
            'is_admin' => $is_admin,
            'shipper_status' => $shipper_status,
        );

        $shipper_head_icon_attachment_id = '';
        if ($shipper_head_icon_img_attachment_id) {
            $shipper_head_icon_attachment_id = move_upload_file($shipper_head_icon_img_attachment_id, $shipper_data['shipper_head_icon']);

            $data['shipper_head_icon'] = $shipper_head_icon_attachment_id;
        }

        $shipper_pic_attachment_id = '';
        if ($shipper_pic_img_attachment_id) {
            $shipper_pic_attachment_id = move_upload_file($shipper_pic_img_attachment_id, $shipper_data['shipper_pic']);

            $data['shipper_pic'] = $shipper_pic_attachment_id;
        }

        $shipper_card_pic_attachment_id = '';
        if ($shipper_card_pic_img_attachment_id) {
            $shipper_card_pic_attachment_id = move_upload_file($shipper_card_pic_img_attachment_id, $shipper_data['shipper_card_pic']);

            $data['shipper_card_pic'] = $shipper_card_pic_attachment_id;
        }

        $where = array(
            'shipper_id' => $id,
        );
        $this->common_model->update('shipper', $data, $where);

        // 插入日志
        $log_remark = '编辑货主，货主ID：<a href="'.site_url(''.$this->appfolder.'/shipper/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(501, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/shipper');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();
        
        $data = array(
            'shipper_status' => 2,
        );
        $where = array(
            'shipper_id' => $id,
        );
        $this->common_model->update('shipper', $data, $where);

        // 插入日志
        $log_remark = '删除货主，货主ID：<a href="'.site_url(''.$this->appfolder.'/shipper/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(502, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/shipper');
    }
}

?>