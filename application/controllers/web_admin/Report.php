<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends Admin_Controller {

    public function index()
    {
        $this->set_path('意见反馈列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();

        // 组合搜索条件
        $search_str = '?1=1';

        $this->data['driver_name'] = $this->input->get('driver_name');
        if (!empty($this->data['driver_name'])) {
            $s_where = array();
            $s_where['driver_name LIKE'] = '%'.$this->data['driver_name'].'%';
            $driver_data_list = $this->driver_service->get_driver_data_list($s_where);
            if ($driver_data_list) {
                $driver_ids = array();
                foreach ($driver_data_list as $value) {
                    $driver_ids[] = $value['driver_id'];
                }
                $where['driver_id'] = $driver_ids;
            }

            $search_str .= '&driver_name='.$this->data['driver_name'];
        }

        $this->data['status'] = $this->input->get('status');
        if ($this->data['status'] != 'all') {
            $this->data['status'] = $this->data['status'] ? $this->data['status'] : 0;
            $where['status'] = $this->data['status'];
            $search_str .= '&status='.$this->data['status'];
        }
        
        $this->data['total'] = $this->common_model->get_count('report', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/report/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('report', $where, $per_page, $cur_num, 'id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                // 司机信息
                $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/driver/report_view', $this->data);
    }

    public function update()
    {
        $id = $this->input->get('id');
        $status = $this->input->get('status');

        $this->common_model->trans_begin();
        
        $data = array(
            'status' => $status,
        );
        $where = array(
            'id' => $id,
        );
        $this->common_model->update('report', $data, $where);

        if ($status == 1) {
            $log_text = '已采纳反馈意见';
            $log_type = 350;
        } elseif ($status == 2) {
            $log_text = '未采纳反馈意见';
            $log_type = 351;
        }

        // 插入日志
        $log_remark = ''.$log_text.'，ID：'.$id.'，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log($log_type, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/report');
    }
}

?>