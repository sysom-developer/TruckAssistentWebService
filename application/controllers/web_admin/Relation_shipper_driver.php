<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relation_shipper_driver extends Admin_Controller {

    public function shipper_company_data()
    {
        $this->data['shipper_company_id'] = $this->input->get('shipper_company_id');

        if ($this->data['shipper_company_id'] > 0) {
            $this->data['shipper_company_data'] = $this->shipper_company_service->get_shipper_company_by_id($this->data['shipper_company_id']);
        } else {
            $shipper_company_data = $this->shipper_company_service->get_shipper_company_data_list();
            $this->data['shipper_company_data'] = $shipper_company_data[0];
        }

        return $this->data['shipper_company_data']['id'];
    }

    public function index()
    {
        $this->set_path('司机关联货运公司列表');
        
        $this->data['shipper_company_id'] = $this->shipper_company_data();

        $this->data['get_ushipper_company_options'] = $this->shipper_company_service->get_shipper_company_options($this->data['shipper_company_id']);

        // 货运公司关联司机总数
        $search_str = '?1=1';
        $search_where = '';
        if (!empty($this->data['shipper_company_id'])) {
            $search_where .= 'AND tsd.shipper_company_id = ' . $this->data['shipper_company_id'] . ' ';
            $search_str .= '&shipper_company_id='.$this->data['shipper_company_id'];
        }
        $record = $this->db->query('
            SELECT COUNT(td.driver_id) AS count
            FROM thy_shipper_driver AS tsd
            LEFT JOIN thy_driver AS td ON td.driver_id = tsd.driver_id
            WHERE td.driver_status = 1
            AND td.driver_type = 1
            ' . $search_where . '
        ')->row_array();
        $this->data['relation_total'] = $record['count'];
        
        $this->load->view(''.$this->appfolder.'/relation/default_relation_shipper_driver_view', $this->data);
    }

    public function current_data()
    {
        $per_page = 8;    // 每页显示数量
        $this->data['offset'] = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->data['shipper_company_id'] = $this->shipper_company_data();

        // 组合搜索条件
        $search_str = '?1=1';
        $search_where = '';
        if (!empty($this->data['shipper_company_id'])) {
            $search_where .= 'AND tsd.shipper_company_id = ' . $this->data['shipper_company_id'] . ' ';
            $search_str .= '&shipper_company_id='.$this->data['shipper_company_id'];
        }

        $record = $this->db->query('
            SELECT COUNT(td.driver_id) AS count
            FROM thy_shipper_driver AS tsd
            LEFT JOIN thy_driver AS td ON td.driver_id = tsd.driver_id
            WHERE td.driver_status = 1
            AND td.driver_type = 1
            ' . $search_where . '
        ')->row_array();
        $this->data['total'] = $record['count'];
        
        // 分页初始化
        $page_config = array();
        $page_config['page_query_string'] = TRUE;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/relation_shipper_driver/current_data/'.$search_str);
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->db->query('
            SELECT td.*
            FROM thy_shipper_driver AS tsd
            LEFT JOIN thy_driver AS td ON td.driver_id = tsd.driver_id
            WHERE td.driver_status = 1
            AND td.driver_type = 1
            ' . $search_where . '
            ORDER BY td.driver_id DESC
            LIMIT ' . $this->data['offset'] . ', ' . $per_page . '
        ')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                $value['checked'] = 'checked';
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/relation/relation_shipper_driver_view', $this->data);
    }

    public function all_data()
    {
        $per_page = 8;    // 每页显示数量
        $this->data['offset'] = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $this->data['shipper_company_id'] = $this->shipper_company_data();

        // 组合搜索条件
        $search_str = '?1=1';
        $search_where = '';
        if (!empty($this->data['shipper_company_id'])) {
            $search_str .= '&shipper_company_id='.$this->data['shipper_company_id'];
        }

        $record = $this->db->query('
            SELECT COUNT(driver_id) AS count
            FROM thy_driver
            WHERE driver_status = 1
            AND driver_type = 1
            ' . $search_where . '
        ')->row_array();
        $this->data['total'] = $record['count'];
        
        // 分页初始化
        $page_config = array();
        $page_config['page_query_string'] = TRUE;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/relation_shipper_driver/all_data/'.$search_str);
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->db->query('
            SELECT *
            FROM thy_driver
            WHERE driver_status = 1
            AND driver_type = 1
            ' . $search_where . '
            ORDER BY driver_id DESC
            LIMIT ' . $this->data['offset'] . ', ' . $per_page . '
        ')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                // 查询关联表
                $where = array(
                    'driver_id' => $value['driver_id'],
                    'shipper_company_id' => $this->data['shipper_company_id'],
                );
                $realtion_data = $this->common_model->get_data('shipper_driver', $where)->row_array();
                $value['checked'] = '';
                if ($realtion_data) {
                    if (count($realtion_data) > 0) {
                        $value['checked'] = 'checked';
                    }
                }
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/relation/relation_shipper_driver_view', $this->data);
    }

    public function ajax_relation_handle()
    {
        $shipper_company_id = $this->input->post('shipper_company_id');
        $driver_id = $this->input->post('driver_id');
        $chk_status = $this->input->post('chk_status');

        $this->common_model->trans_begin();

        $where = array(
            'shipper_company_id' => $shipper_company_id,
            'driver_id' => $driver_id,
        );
        $count = $this->common_model->get_count('shipper_driver', $where);  

        if ($chk_status == 1 && $count == 0) {
            $data = array(
                'shipper_company_id' => $shipper_company_id,
                'driver_id' => $driver_id,
                'create_time' => date('Y-m-d H:i:s', time()),
            );
            $this->common_model->insert('shipper_driver', $data);
        } elseif ($chk_status == 0) {
            $where = array(
                'shipper_company_id' => $shipper_company_id,
                'driver_id' => $driver_id,
            );
            $this->common_model->delete('shipper_driver', $where);
        }

        // 插入日志
        $log_remark = '设置司机关联货运公司，司机ID：<a href="'.site_url($this->appfolder."/driver/edit_data/".$driver_id."").'">'.$driver_id.'</a>，货运公司ID：<a href="'.site_url($this->appfolder."/shipper_company/edit_data/".$shipper_company_id."").'">'.$shipper_company_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(1002, $log_remark, $this->user_info['id']);

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
}

?>