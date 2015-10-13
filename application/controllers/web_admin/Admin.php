<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

	public function index()
	{
    	$this->set_path('管理员列表');
	    
	    $per_page = 16;    // 每页显示数量
	    $offset = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

	    $where = array();

	    // 组合搜索条件
        $search_str = '?';
        $this->data['username'] = $this->input->get('username');
        if (!empty($this->data['username'])) {
            $where['username like'] = '%'.$this->data['username'].'%';
            $search_str .= 'username='.$this->data['username'];
        }

	    $this->data['total'] = $this->common_model->get_count('admin', $where);
	    
	    // 分页初始化
	    $page_config = array();
	    $page_config['page_query_string'] = TRUE;
	    $page_config['base_url'] = site_url(''.$this->appfolder.'/admin/index/'.$search_str);
	    $page_config['total_rows'] = $this->data['total'];
	    $page_config['per_page'] = $per_page;
	    $page_config['first_link'] = '第一页';
	    $page_config['last_link'] = '最后一页';
	    $page_config['prev_link'] = '上一页';
	    $page_config['next_link'] = '下一页';
	    $this->pagination->initialize($page_config);
	    
	    $this->data['data_list'] = $this->common_model->get_data('admin', $where, $per_page, $offset)->result_array();
	    if ($this->data['data_list']) {
	    	foreach ($this->data['data_list'] as &$data) {
	    		$data['depart_data'] = $this->common_model->get_data('admin_department', array('id' => $data['depart_id']))->row_array();
	    	}
	    }
	    $this->data['links'] = $this->pagination->create_links();
	    
		$this->load->view(''.$this->appfolder.'/admin_view', $this->data);
	}
	
	public function add_data()
	{
    	$this->set_path('添加管理员');

    	$this->data['department_options'] = $this->tree_admin();
	    
	    $this->load->view(''.$this->appfolder.'/add_admin_view', $this->data);
	}
	
	public function act_add_data()
	{
		$depart_id = $this->input->post('depart_id');
	    $new_username = trim($this->input->post('new_username', TRUE));
	    $new_password = $this->input->post('new_password', TRUE);
	    $new_confirm_password = $this->input->post('new_confirm_password', TRUE);
	    $controller_name = $this->input->post('controller_name', TRUE);
	    
	    if (empty($new_username) || empty($new_password)) {
	        show_error('用户名和密码不可以为空，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }
	    
	    if ($new_password != $new_confirm_password) {
	        show_error('两次输入的密码不一致，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }
	    
	    $where = array(
	        'username' => $new_username,
	    );
	    $data = $this->common_model->get_data('admin', $where)->row_array();
	    if ($data) {
	        show_error('用户名已经存在，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }

	    $this->common_model->trans_begin();
	    
	    $time = time();
	    $data = array(
	    	'depart_id' => $depart_id,
	        'username' => $new_username,
	        'password' => do_hash($new_password, 'sha1'),
	        'controller_name' => serialize($controller_name),
	        'cretime' => $time,
	        'updatetime' => $time,
	    );
	    $insert_id = $this->common_model->insert('admin', $data);

	    // 插入日志
	    $log_remark = '新增管理员，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$insert_id.'').'">查看</a>';
	    insert_admin_log(1, $log_remark, $this->user_info['id']);

	    if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

	        show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }

        $this->common_model->trans_commit();
	    
	    redirect(''.$this->appfolder.'/admin');
	}
	
	public function edit_data()
	{
    	$this->set_path('编辑管理员');
	    
	    $this->data['id'] = $this->uri->rsegment(3);
	    
	    $where = array(
	        'id' => $this->data['id'],
	    );
	    $this->data['data'] = $this->common_model->get_data('admin', $where)->row_array();
	    $this->data['data']['controller_name'] = unserialize($this->data['data']['controller_name']);
	    $this->data['department_options'] = $this->tree_admin(0, $this->data['data']['depart_id']);
	    
	    $this->load->view(''.$this->appfolder.'/edit_admin_view', $this->data);
	}
	
	public function act_edit_data()
	{
	    $id = $this->input->post('id');
	    $depart_id = $this->input->post('depart_id');
	    $former_username = $this->input->post('former_username', TRUE);
	    $new_username = $this->input->post('new_username', TRUE);
	    $new_password = $this->input->post('new_password', TRUE);
	    $new_confirm_password = $this->input->post('new_confirm_password', TRUE);
	    $controller_name = $this->input->post('controller_name', TRUE);
	    
	    if (!is_numeric($id)) {
	        show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }
	    
	    if (empty($new_username)) {
	        show_error('用户名不可以为空，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }

	    $this->common_model->trans_begin();
	    
	    $where = array(
	        'username' => $new_username,
	    );
	    
	    // 用户名已经存在
	    $data = $this->common_model->get_data('admin', $where)->row_array();
	    if ($former_username != $new_username && $data) {
	        show_error('用户名已经存在，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }
	    
	    $data = array(
	    	'depart_id' => $depart_id,
	        'username' => $new_username,
	        'controller_name' => serialize($controller_name),
	        'updatetime' => time(),
	    );

		// 没有设置密码不更新
		if (!empty($new_password) && !empty($new_confirm_password)) {
            if ($new_password != $new_confirm_password) {
                show_error('两次输入的密码不一致，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
            }

            $data['password'] = do_hash($new_password, 'sha1');
        }

	    $where = array(
	        'id' => $id,
	    );
	    
	    $this->common_model->update('admin', $data, $where);

	    // 插入日志
	    $log_remark = '编辑管理员，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$id.'').'">查看</a>';
	    insert_admin_log(2, $log_remark, $this->user_info['id']);

	    if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
	    
	    redirect(''.$this->appfolder.'/admin');
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
	    
	    // 超级管理员不能删除
	    $data = $this->common_model->get_data('admin', $where)->row_array();
	    if ($data['is_super_admin'] == 1) {
	        show_error('操作失败，超级管理员不能删除，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }
	    
	    $this->common_model->delete('admin', $where);

	    // 插入日志
	    $log_remark = '删除管理员，管理员ID：'.$id.'';
	    insert_admin_log(3, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
	    
	    redirect(''.$this->appfolder.'/admin');
	}
	
    public function delete_all()
	{
	    $select_ids = $this->input->post('select_ids', TRUE);
	    $select_ids = substr($select_ids, 0, -1);
	    $ids = explode(",", $select_ids);

	    $this->common_model->trans_begin();
	    
	    $where = array(
	        'id' => $ids,
	    );
	    
	    // 超级管理员不能删除
	    $data_list = $this->common_model->get_data('admin', $where)->result_array();
	    if ($data_list) {
	        foreach ($data_list as $value) {
    	        if ($value['is_super_admin'] == 1) {
    	            show_error('操作失败，超级管理员不能删除，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
    	        }
	        }
	    }
	    
	    $this->common_model->delete('admin', $where);

	    // 插入日志
	    $log_remark = '批量删除管理员，管理员ID：'.$select_ids.'';
	    insert_admin_log(4, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
	    
	    redirect(''.$this->appfolder.'/admin');
	}
	
	public function detail()
	{
    	$this->set_path('查看管理员');
	    
	    $id = $this->uri->rsegment(3);
	    
	    if (!is_numeric($id)) {
	        show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
	    }
	    
	    $where = array(
	        'id' => $id,
	    );
	    $this->data['data'] = $this->common_model->get_data('admin', $where)->row_array();
	    $this->data['data']['depart_data'] = $this->common_model->get_data('admin_department', array('id' => $this->data['data']['depart_id']))->row_array();
	    
	    $this->load->view(''.$this->appfolder.'/detail_admin_view', $this->data);
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