<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_log extends Admin_Controller {

    public function index()
    {
        $this->set_path('日志列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('admin_log', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/admin_log/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('admin_log', $where, $per_page, $cur_num, 'id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$data) {
                $admin_info = $this->common_model->get_data('admin', array('id' => $data['admin_id']))->row_array();
                $data['admin_info'] = $admin_info;
            }
        }
        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/admin_log_view', $this->data);
    }
    
    public function detail()
    {
        $this->set_path('查看日志');
        
        $id = $this->uri->rsegment(3);
        
        if (!is_numeric($id)) {
            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        
        $where = array(
            'id' => $id,
        );
        $this->data['data'] = $this->common_model->get_data('admin_log', $where)->row_array();
        if ($this->data['data']) {
            $admin_info = $this->common_model->get_data('admin', array('id' => $this->data['data']['admin_id']))->row_array();
            $this->data['data']['admin_info'] = $admin_info;
        }
        
        $this->load->view(''.$this->appfolder.'/detail_admin_log_view', $this->data);
    }
}

?>