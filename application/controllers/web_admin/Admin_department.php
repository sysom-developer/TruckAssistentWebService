<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_department extends Admin_Controller {

    public function index()
    {
        $this->set_path('部门列表');
        
        $per_page = 16;    // 每页显示数量
        $offset = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $where = array();

        // 组合搜索条件
        $search_str = '?';
        $this->data['depart_name'] = $this->input->get('depart_name');
        if (!empty($this->data['depart_name'])) {
            $where['depart_name like'] = '%'.$this->data['depart_name'].'%';
            $search_str .= 'depart_name='.$this->data['depart_name'];
        }

        $this->data['total'] = $this->common_model->get_count('admin_department', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['page_query_string'] = TRUE;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/admin_department/index/'.$search_str);
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('admin_department', $where, $per_page, $offset)->result_array();
        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/admin_department_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加部门');

        $this->data['department_options'] = $this->tree_admin();
        
        $this->load->view(''.$this->appfolder.'/add_admin_department_view', $this->data);
    }
    
    public function act_add_data()
    {
        $parent_depart_id = $this->input->post('parent_depart_id', TRUE);
        $depart_name = trim($this->input->post('depart_name', TRUE));

        if ($parent_depart_id === FALSE) {
            show_error('请选择上级部门，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        
        if (empty($depart_name)) {
            show_error('部门名称不可以为空，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        // 获取级别
        $parent_depart = $this->common_model->get_data('admin_department', array('id' => $parent_depart_id))->row_array();

        $time = time();
        $data = array(
            'parent_depart_id' => $parent_depart_id,
            'depart_name' => $depart_name,
            'depart_level' => $parent_depart_id == 0 ? $parent_depart_id : $parent_depart['depart_level']+1,
            'cretime' => $time,
            'updatetime' => $time,
        );
        $insert_id = $this->common_model->insert('admin_department', $data);

        // 插入日志
        $log_remark = '新增部门，部门ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$insert_id.'').'">查看</a>';
        insert_admin_log(5, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/admin_department');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑部门');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('admin_department', $where)->row_array();

        $this->data['department_options'] = $this->tree_admin(0, $this->data['data']['parent_depart_id']);
        
        $this->load->view(''.$this->appfolder.'/edit_admin_department_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $parent_depart_id = $this->input->post('parent_depart_id', TRUE);
        $depart_name = trim($this->input->post('depart_name', TRUE));

        if ($parent_depart_id === FALSE) {
            show_error('请选择上级部门，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        
        if (empty($depart_name)) {
            show_error('部门名称不可以为空，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();

        // 获取级别
        $parent_depart = $this->common_model->get_data('admin_department', array('id' => $parent_depart_id))->row_array();

        $time = time();
        $data = array(
            'parent_depart_id' => $parent_depart_id,
            'depart_name' => $depart_name,
            'depart_level' => $parent_depart_id == 0 ? $parent_depart_id : $parent_depart['depart_level']+1,
            'updatetime' => $time,
        );
        $where = array(
            'id' => $id,
        );
        $this->common_model->update('admin_department', $data, $where);

        // 插入日志
        $log_remark = '编辑部门，部门ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$id.'').'">查看</a>';
        insert_admin_log(6, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/admin_department');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);
        
        if (!is_numeric($id)) {
            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();
        
        $where = array(
            'id' => $id,
        );
        
        $this->common_model->delete('admin_department', $where);

        // 插入日志
        $log_remark = '删除部门，部门ID：'.$id.'';
        insert_admin_log(7, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/admin_department');
    }
    
    public function delete_all()
    {
        $select_ids = $this->input->post('select_ids', TRUE);
        $select_ids = substr($select_ids, 0, -1);

        $this->common_model->trans_begin();
        
        $where = array(
            'id' => explode(",", $select_ids),
        );
        
        $this->common_model->delete('admin_department', $where);

        // 插入日志
        $log_remark = '批量删除部门，部门ID：'.$select_ids.'';
        insert_admin_log(8, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/admin_department');
    }
    
    public function detail()
    {
        $this->set_path('查看部门');
        
        $id = $this->uri->rsegment(3);
        
        if (!is_numeric($id)) {
            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
        
        $where = array(
            'id' => $id,
        );
        $this->data['data'] = $this->common_model->get_data('admin_department', $where)->row_array();

        $this->data['department_options'] = $this->tree_admin(0, $this->data['data']['parent_depart_id']);
        
        $this->load->view(''.$this->appfolder.'/detail_admin_department_view', $this->data);
    }
    
    public function tree_admin($parent_id = 0, $selected_id = 0)
    {
        $options = '';

        $where = array(
            'parent_depart_id' => $parent_id,
        );
        $data_list = $this->common_model->get_data('admin_department', $where)->result_array();
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($selected_id == $data['id']) {
                    $selected = 'selected';
                }

                $options .= "<option ".$selected." value=".$data['id']."";
                $options .= ">".str_repeat('&nbsp;&nbsp;', $data['depart_level']*3).'>'.$data['depart_name']."</option>";
                $options .= $this->tree_admin($data['id'], $selected_id);
            }
        }

        return $options;
    }
}

?>