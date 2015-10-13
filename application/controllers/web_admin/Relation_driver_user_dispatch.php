<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relation_driver_user_dispatch extends Admin_Controller {

    public function user_dispatch_data()
    {
        $this->data['user_dispatch_id'] = $this->input->get('user_dispatch_id');

        if ($this->data['user_dispatch_id'] > 0) {
            $this->data['user_dispatch_data'] = $this->user_dispatch_service->get_user_dispatch_by_id($this->data['user_dispatch_id']);
        } else {
            $user_dispatch_data = $this->user_dispatch_service->get_user_dispatch_data_list();
            $this->data['user_dispatch_data'] = $user_dispatch_data[0];
        }

        return $this->data['user_dispatch_data']['id'];
    }

    public function index()
    {
        $this->set_path('司机关联调度列表');
        
        $this->data['user_dispatch_id'] = $this->user_dispatch_data();

        $this->data['get_user_dispatch_options'] = $this->user_dispatch_service->get_user_dispatch_options($this->data['user_dispatch_id']);
        
        $this->load->view(''.$this->appfolder.'/relation/default_relation_driver_user_dispatch_view', $this->data);
    }

    public function current_data()
    {
        $per_page = 10;    // 每页显示数量
        $this->data['offset'] = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->data['user_dispatch_id'] = $this->user_dispatch_data();

        // 组合搜索条件
        $search_str = '?1=1';
        $search_where = '';
        if (!empty($this->data['user_dispatch_id'])) {
            $search_where .= 'AND r.user_dispatch_id = ' . $this->data['user_dispatch_id'] . ' ';
            $search_str .= '&user_dispatch_id='.$this->data['user_dispatch_id'];
        }

        $record = $this->db->query('
            SELECT COUNT(d.driver_id) AS count
            FROM thy_relation_driver_user_dispatch AS r
            LEFT JOIN thy_driver AS d ON r.driver_id = d.driver_id
            LEFT JOIN thy_route AS tr ON r.route_id = tr.route_id
            WHERE d.driver_status = 1
            AND d.driver_type = 1
            ' . $search_where . '
        ')->row_array();
        $this->data['total'] = $record['count'];
        
        // 分页初始化
        $page_config = array();
        $page_config['page_query_string'] = TRUE;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/relation_driver_user_dispatch/current_data/'.$search_str);
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->db->query('
            SELECT r.*, d.*, r.*
            FROM thy_relation_driver_user_dispatch AS r
            LEFT JOIN thy_driver AS d ON r.driver_id = d.driver_id
            LEFT JOIN thy_route AS tr ON r.route_id = tr.route_id
            WHERE d.driver_status = 1
            AND d.driver_type = 1
            ' . $search_where . '
            ORDER BY r.id DESC
            LIMIT ' . $this->data['offset'] . ', ' . $per_page . '
        ')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                // 调度名称
                $value['user_dispatch_data'] = $this->user_dispatch_service->get_user_dispatch_by_id($value['user_dispatch_id']);

                // 线路名称
                $value['route_data'] = $this->route_service->get_route_by_id($value['route_id']);

                // 司机名称
                $value['driver_data'] = $this->driver_service->get_driver_by_id($value['driver_id']);
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/relation/relation_driver_user_dispatch_view', $this->data);
    }

    public function route_driver_all_data()
    {
        $this->data['user_dispatch_id'] = $this->user_dispatch_data();

        // 所有线路
        $this->data['route_data_list'] = $this->db->query('
            SELECT *
            FROM thy_route
        ')->result_array();

        // 所有司机
        $this->data['driver_data_list'] = $this->db->query('
            SELECT *
            FROM thy_driver
            WHERE driver_status = 1
            AND driver_type = 1
        ')->result_array();
        
        $this->load->view(''.$this->appfolder.'/relation/relation_route_driver_user_dispatch_view', $this->data);
    }
    public function ajax_relation_handle()
    {
        $user_dispatch_id = $this->input->post('user_dispatch_id');
        $route_id = $this->input->post('route_id');
        $driver_id = $this->input->post('driver_id');

        $this->common_model->trans_begin();

        $where = array(
            'user_dispatch_id' => $user_dispatch_id,
            'route_id' => $route_id,
            'driver_id' => $driver_id,
        );
        $count = $this->common_model->get_count('relation_driver_user_dispatch', $where);  

        if ($count == 0) {
            $data = array(
                'user_dispatch_id' => $user_dispatch_id,
                'route_id' => $route_id,
                'driver_id' => $driver_id,
            );
            $this->common_model->insert('relation_driver_user_dispatch', $data);
        } else {
            $where = array(
                'user_dispatch_id' => $user_dispatch_id,
                'route_id' => $route_id,
                'driver_id' => $driver_id,
            );
            $data = array(
                'user_dispatch_id' => $user_dispatch_id,
                'route_id' => $route_id,
                'driver_id' => $driver_id,
            );
            $this->common_model->update('relation_driver_user_dispatch', $where, $data);
        }

        // 插入日志
        $log_remark = '设置司机关联调度，线路ID：'.$route_id.'，司机ID：<a href="'.site_url($this->appfolder."/driver/edit_data/".$driver_id."").'">'.$driver_id.'</a>，调度ID：<a href="'.site_url($this->appfolder."/user_dispatch/edit_data/".$user_dispatch_id."").'">'.$user_dispatch_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(1000, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error = array(
                'error' => -1,
            );
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_commit();

        $error = array(
            'error' => 1,
        );
        echo json_encode($error);
        exit;
    }

    public function delete_relation()
    {
        $id = $this->input->get('id');
        $user_dispatch_id = $this->input->get('user_dispatch_id');
        $offset = $this->input->get('offset');
        $fetch_method = $this->input->get('fetch_method');

        $this->common_model->trans_begin();

        $where = array(
            'id' => $id,
        );
        $this->common_model->delete('relation_driver_user_dispatch', $where);

        // 插入日志
        $log_remark = ' 删除司机关联调度，调度ID：<a href="'.site_url($this->appfolder."/user_dispatch/edit_data/".$user_dispatch_id."").'">'.$user_dispatch_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(1001, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('删除失败，请重新操作，<a href="'.site_url($this->appfolder.'/relation_driver_user_dispatch/'.$fetch_method.'/?user_dispatch_id='.$user_dispatch_id.'&per_page='.$offset.'">返回</a>').'', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        show_error('删除成功，<a href="'.site_url($this->appfolder.'/relation_driver_user_dispatch/'.$fetch_method.'/?user_dispatch_id='.$user_dispatch_id.'&per_page='.$offset.'">返回</a>').'', 500, '系统提示');
    }
}

?>