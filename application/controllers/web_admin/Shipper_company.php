<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipper_company extends Admin_Controller {

    public function index()
    {
        $this->set_path('货运公司列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('shipper_company', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/shipper_company/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('shipper_company', $where, $per_page, $cur_num, 'id', 'DESC')->result_array();

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/shipper_company/shipper_company_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加货运公司');
        
        $this->load->view(''.$this->appfolder.'/shipper_company/add_shipper_company_view', $this->data);
    }
    
    public function act_add_data()
    {
        $shipper_company_name = trim($this->input->post('shipper_company_name'));
        $zipcode = trim($this->input->post('zipcode'));
        $shipper_phone = trim($this->input->post('shipper_phone'));
        $shipper_fax = trim($this->input->post('shipper_fax'));
        $shipper_company_addr = trim($this->input->post('shipper_company_addr'));
        $shipper_company_desc = trim($this->input->post('shipper_company_desc'));
        $is_special = $this->input->post('is_special');
        $is_select = $this->input->post('is_select');
        $shipper_company_score = intval($this->input->post('shipper_company_score'));

        if (empty($shipper_company_name)) {
            show_error('请输入货运公司名称，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($zipcode)) {
            show_error('请输入邮编，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($shipper_phone)) {
            show_error('请输入固定电话，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($shipper_fax)) {
            show_error('请输入传真，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($shipper_company_addr)) {
            show_error('请输入货运公司地址，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($shipper_company_desc)) {
            show_error('请输入货运公司简介，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'shipper_company_name' => $shipper_company_name,
            'zipcode' => $zipcode,
            'shipper_phone' => $shipper_phone,
            'shipper_fax' => $shipper_fax,
            'shipper_company_addr' => $shipper_company_addr,
            'shipper_company_desc' => $shipper_company_desc,
            'is_special' => $is_special,
            'is_select' => $is_select,
            'shipper_company_score' => $shipper_company_score,
            'create_time' => date("Y-m-d H:i:s", $time),
        );
        $insert_id = $this->common_model->insert('shipper_company', $data);

        // 插入日志
        $log_remark = '新增货运公司，货运公司ID：<a href="'.site_url(''.$this->appfolder.'/shipper_company/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(500, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/shipper_company');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑货运公司');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('shipper_company', $where)->row_array();
        
        $this->load->view(''.$this->appfolder.'/shipper_company/edit_shipper_company_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $shipper_company_name = trim($this->input->post('shipper_company_name'));
        $zipcode = trim($this->input->post('zipcode'));
        $shipper_phone = trim($this->input->post('shipper_phone'));
        $shipper_fax = trim($this->input->post('shipper_fax'));
        $shipper_company_addr = trim($this->input->post('shipper_company_addr'));
        $shipper_company_desc = trim($this->input->post('shipper_company_desc'));
        $is_special = $this->input->post('is_special');
        $is_select = $this->input->post('is_select');
        $shipper_company_score = intval($this->input->post('shipper_company_score'));

        if (empty($shipper_company_name)) {
            show_error('请输入货运公司名称，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($zipcode)) {
            show_error('请输入邮编，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($shipper_phone)) {
            show_error('请输入固定电话，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($shipper_fax)) {
            show_error('请输入传真，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($shipper_company_addr)) {
            show_error('请输入货运公司地址，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        if (empty($shipper_company_desc)) {
            show_error('请输入货运公司简介，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        $data = array(
            'shipper_company_name' => $shipper_company_name,
            'zipcode' => $zipcode,
            'shipper_phone' => $shipper_phone,
            'shipper_fax' => $shipper_fax,
            'shipper_company_addr' => $shipper_company_addr,
            'shipper_company_desc' => $shipper_company_desc,
            'is_special' => $is_special,
            'is_select' => $is_select,
            'shipper_company_score' => $shipper_company_score,
        );
        $where = array(
            'id' => $id,
        );
        $this->common_model->update('shipper_company', $data, $where);

        // 插入日志
        $log_remark = '编辑货运公司，货运公司ID：<a href="'.site_url(''.$this->appfolder.'/shipper_company/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(501, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/shipper_company');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();
        
        $where = array(
            'id' => $id,
        );
        $this->common_model->delete('shipper_company', $where);

        // 插入日志
        $log_remark = '删除货运公司，货运公司ID：<a href="'.site_url(''.$this->appfolder.'/shipper_company/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(502, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/shipper_company');
    }
}

?>