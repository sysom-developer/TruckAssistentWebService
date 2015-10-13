<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver extends Admin_Controller {

    public function index()
    {
        $this->set_path('司机列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $where = array(
            'driver_status' => 1,
        );

        // 组合搜索条件
        $search_str = '?1=1';
        $this->data['driver_name'] = $this->input->get('driver_name');
        if (!empty($this->data['driver_name'])) {
            $where['driver_name LIKE'] = '%'.$this->data['driver_name'].'%';
            $search_str .= '&driver_name='.$this->data['driver_name'];
        }

        $this->data['driver_mobile'] = $this->input->get('driver_mobile');
        if (!empty($this->data['driver_mobile'])) {
            $where['driver_mobile LIKE'] = '%'.$this->data['driver_mobile'].'%';
            $search_str .= '&driver_mobile='.$this->data['driver_mobile'];
        }

        $this->data['driver_status'] = $this->input->get('driver_status');
        if (!empty($this->data['driver_status'])) {
            $where['driver_status'] = $this->data['driver_status'];
            $search_str .= '&driver_status='.$this->data['driver_status'];
        }
        
        $this->data['total'] = $this->common_model->get_count('driver', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['display_pages'] = FALSE;
        $page_config['page_query_string'] = TRUE;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/driver/index/'.$search_str);
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('driver', $where, $per_page, $cur_num, 'driver_id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_head_icon']);
                $value['driver_head_icon_http_file'] = $attachment_data['http_file'];

                $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_card_icon']);
                $value['driver_card_icon_http_file'] = $attachment_data['http_file'];

                $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_license_icon']);
                $value['driver_license_icon_http_file'] = $attachment_data['http_file'];

                $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_vehicle_license_icon']);
                $value['driver_vehicle_license_icon_http_file'] = $attachment_data['http_file'];

                $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_pic']);
                $value['driver_pic_http_file'] = $attachment_data['http_file'];

                $where = array(
                    'driver_id' => $value['driver_id'],
                    'order_type' => array(2, 3, 4),
                );
                $order_data = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                $value['exec_time'] = '-';
                if (empty($order_data)) {
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'order_type' => 5,
                    );
                    $last_order_data = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
                    // 等待时间
                    if ($last_order_data['order_end_time']) {
                        $exec_time = $last_order_data['order_end_time'];
                        $value['exec_time'] = get_stay_time($exec_time);
                    }
                }
            }
        }

        $this->data['links'] = $this->pagination->create_links();

        // 有效司机总数
        $where = array(
            'driver_status' => 1,
        );
        $this->data['valid_total'] = $this->common_model->get_count('driver', $where);

        // 无效司机总数
        $where = array(
            'driver_status' => 2,
        );
        $this->data['invalid_status'] = $this->common_model->get_count('driver', $where);
        
        $this->load->view(''.$this->appfolder.'/driver/driver_view', $this->data);
    }

    public function ajax_get_region()
    {
        $error = array(
            'code' => 'success'
        );

        $id = $this->input->post('id');
        
        $where = array(
            'parent_id' => $id,
        );
        $data = $this->region_service->get_region_data_list($where);
        
        $error['data'] = $data;
        echo json_encode($error);
        exit;
    }
    
    public function add_data()
    {
        $this->set_path('添加司机');

        // 省份
        $where = array(
            'parent_id' => 1,
        );
        $this->data['get_region_options'] = $this->region_service->get_region_options(0, $where);
        
        $this->load->view(''.$this->appfolder.'/driver/add_driver_view', $this->data);
    }
    
    public function act_add_data()
    {
        $driver_role = $this->input->post('driver_role');
        $driver_name = $this->input->post('driver_name');
        $login_name = $this->input->post('login_name');
        $login_pwd = $this->input->post('login_pwd');
        $driver_nick_name = $this->input->post('driver_nick_name');
        $driver_sex = $this->input->post('driver_sex');
        $driver_signature = $this->input->post('driver_signature');
        $driver_province = $this->input->post('driver_province');
        $driver_city = $this->input->post('driver_city');
        $driver_mobile = $this->input->post('driver_mobile');
        $driver_tel = $this->input->post('driver_tel');
        $driver_card_num = $this->input->post('driver_card_num');
        $driver_license = $this->input->post('driver_license');
        $driver_head_icon_img_attachment_id = $this->input->post('driver_head_icon_img_attachment_id');
        $driver_card_icon_img_attachment_id = $this->input->post('driver_card_icon_img_attachment_id');
        $driver_license_icon_img_attachment_id = $this->input->post('driver_license_icon_img_attachment_id');
        $driver_vehicle_license_icon_img_attachment_id = $this->input->post('driver_vehicle_license_icon_img_attachment_id');
        $driver_pic_img_attachment_id = $this->input->post('driver_pic_img_attachment_id');
        $driver_status = $this->input->post('driver_status');
        $driver_type = $this->input->post('driver_type');
        $driver_score = intval($this->input->post('driver_score'));

        $this->common_model->trans_begin();

        $driver_head_icon_attachment_id = '';
        if ($driver_head_icon_img_attachment_id) {
            $driver_head_icon_attachment_id = move_upload_file($driver_head_icon_img_attachment_id);
        }

        $driver_card_icon_attachment_id = '';
        if ($driver_card_icon_img_attachment_id) {
            $driver_card_icon_attachment_id = move_upload_file($driver_card_icon_img_attachment_id);
        }

        $driver_license_icon_attachment_id = '';
        if ($driver_license_icon_img_attachment_id) {
            $driver_license_icon_attachment_id = move_upload_file($driver_license_icon_img_attachment_id);
        }
        
        $driver_vehicle_license_attachment_id = '';
        if ($driver_vehicle_license_icon_img_attachment_id) {
            $driver_vehicle_license_attachment_id = move_upload_file($driver_vehicle_license_icon_img_attachment_id);
        }

        $driver_pic_attachment_id = '';
        if ($driver_pic_img_attachment_id) {
            $driver_pic_attachment_id = move_upload_file($driver_pic_img_attachment_id);
        }

        $time = time();

        $data = array(
            'driver_role' => $driver_role,
            'driver_name' => $driver_name,
            'login_name' => $login_name,
            'login_pwd' => $login_pwd,
            'driver_nick_name' => $driver_nick_name,
            'driver_sex' => $driver_sex,
            'driver_signature' => $driver_signature,
            'driver_province' => $driver_province,
            'driver_city' => $driver_city,
            'driver_mobile' => $driver_mobile,
            'driver_tel' => $driver_tel,
            'driver_card_num' => $driver_card_num,
            'driver_license' => $driver_license,
            'driver_head_icon' => $driver_head_icon_attachment_id,
            'driver_card_icon' => $driver_card_icon_attachment_id,
            'driver_license_icon' => $driver_license_icon_attachment_id,
            'driver_vehicle_license_icon' => $driver_vehicle_license_attachment_id,
            'driver_pic' => $driver_pic_attachment_id,
            'driver_status' => $driver_status,
            'driver_type' => $driver_type,
            'driver_score' => $driver_score,
            'create_time' => $time,
        );
        $insert_id = $this->common_model->insert('driver', $data);

        // 插入日志
        $log_remark = '新增司机，司机ID：<a href="'.site_url(''.$this->appfolder.'/driver/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(300, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        // 认证通过，认证失败，发送信鸽
        if (in_array($driver_type, array(1, 3))) {
            $push_st = push_xingeapp($driver_mobile, 1, $driver_type);

            // 记录日志
            $data = array(
                'driver_id' => $insert_id,
                'push_desc' => $push_st,
                'cretime' => $time,
            );
            $this->common_model->insert('xingeapp_driver_log', $data);
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/driver');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑司机');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'driver_id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('driver', $where)->row_array();

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['driver_head_icon']);
        $this->data['data']['driver_head_icon_http_file'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['driver_card_icon']);
        $this->data['data']['driver_card_icon_http_file'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['driver_license_icon']);
        $this->data['data']['driver_license_icon_http_file'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['driver_vehicle_license_icon']);
        $this->data['data']['driver_vehicle_license_icon_http_file'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['driver_pic']);
        $this->data['data']['driver_pic_http_file'] = $attachment_data['http_file'];

        // 省份
        $where = array(
            'parent_id' => 1,
        );
        $this->data['get_region_options'] = $this->region_service->get_region_options($this->data['data']['driver_province'], $where);

        // 城市
        $where = array(
            'parent_id' => $this->data['data']['driver_province'],
        );
        $this->data['get_city_region_options'] = $this->region_service->get_region_options($this->data['data']['driver_city'], $where);
        
        $this->load->view(''.$this->appfolder.'/driver/edit_driver_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $driver_role = $this->input->post('driver_role');
        $driver_name = $this->input->post('driver_name');
        $login_name = $this->input->post('login_name');
        $login_pwd = $this->input->post('login_pwd');
        $driver_nick_name = $this->input->post('driver_nick_name');
        $driver_sex = $this->input->post('driver_sex');
        $driver_signature = $this->input->post('driver_signature');
        $driver_province = $this->input->post('driver_province');
        $driver_city = $this->input->post('driver_city');
        $driver_mobile = $this->input->post('driver_mobile');
        $driver_tel = $this->input->post('driver_tel');
        $driver_card_num = $this->input->post('driver_card_num');
        $driver_license = $this->input->post('driver_license');
        $driver_head_icon_img_attachment_id = $this->input->post('driver_head_icon_img_attachment_id');
        $driver_card_icon_img_attachment_id = $this->input->post('driver_card_icon_img_attachment_id');
        $driver_license_icon_img_attachment_id = $this->input->post('driver_license_icon_img_attachment_id');
        $driver_vehicle_license_icon_img_attachment_id = $this->input->post('driver_vehicle_license_icon_img_attachment_id');
        $driver_pic_img_attachment_id = $this->input->post('driver_pic_img_attachment_id');
        $driver_status = $this->input->post('driver_status');
        $driver_type = $this->input->post('driver_type');
        $driver_score = intval($this->input->post('driver_score'));

        $this->common_model->trans_begin();

        $time = time();

        $where = array(
            'driver_id' => $id,
        );
        $driver_data = $this->common_model->get_data('driver', $where)->row_array();

        $data = array(
            'driver_role' => $driver_role,
            'driver_name' => $driver_name,
            'login_name' => $login_name,
            'login_pwd' => $login_pwd,
            'driver_nick_name' => $driver_nick_name,
            'driver_sex' => $driver_sex,
            'driver_signature' => $driver_signature,
            'driver_province' => $driver_province,
            'driver_city' => $driver_city,
            'driver_mobile' => $driver_mobile,
            'driver_tel' => $driver_tel,
            'driver_card_num' => $driver_card_num,
            'driver_license' => $driver_license,
            'driver_status' => $driver_status,
            'driver_type' => $driver_type,
            'driver_score' => $driver_score,
        );

        $driver_head_icon_attachment_id = '';
        if ($driver_head_icon_img_attachment_id) {
            $driver_head_icon_attachment_id = move_upload_file($driver_head_icon_img_attachment_id, $driver_data['driver_head_icon']);

            $data['driver_head_icon'] = $driver_head_icon_attachment_id;
        }

        $driver_card_icon_attachment_id = '';
        if ($driver_card_icon_img_attachment_id) {
            $driver_card_icon_attachment_id = move_upload_file($driver_card_icon_img_attachment_id, $driver_data['driver_card_icon']);

            $data['driver_card_icon'] = $driver_card_icon_attachment_id;
        }

        $driver_license_icon_attachment_id = '';
        if ($driver_license_icon_img_attachment_id) {
            $driver_license_icon_attachment_id = move_upload_file($driver_license_icon_img_attachment_id, $driver_data['driver_license_icon']);

            $data['driver_license_icon'] = $driver_license_icon_attachment_id;
        }
        
        $driver_vehicle_license_attachment_id = '';
        if ($driver_vehicle_license_icon_img_attachment_id) {
            $driver_vehicle_license_attachment_id = move_upload_file($driver_vehicle_license_icon_img_attachment_id, $driver_data['driver_vehicle_license_icon']);

            $data['driver_vehicle_license_icon'] = $driver_vehicle_license_attachment_id;
        }

        $driver_pic_attachment_id = '';
        if ($driver_pic_img_attachment_id) {
            $driver_pic_attachment_id = move_upload_file($driver_pic_img_attachment_id, $driver_data['driver_pic']);

            $data['driver_pic'] = $driver_pic_attachment_id;
        }

        $where = array(
            'driver_id' => $id,
        );
        $this->common_model->update('driver', $data, $where);

        // 插入日志
        $log_remark = '编辑司机，司机ID：<a href="'.site_url(''.$this->appfolder.'/driver/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(301, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        // 认证通过，认证失败，发送信鸽
        if (in_array($driver_type, array(1, 3))) {
            $push_st = push_xingeapp($driver_mobile, 1, $driver_type);

            $where = array(
                'driver_id' => $id,
                'push_desc' => 'success',
            );
            $count = $this->common_model->get_count('xingeapp_driver_log', $where);

            if ($count == 0) {
                // 记录日志
                $data = array(
                    'driver_id' => $id,
                    'push_desc' => $push_st,
                    'cretime' => $time,
                );
                $this->common_model->insert('xingeapp_driver_log', $data);
            }
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/driver');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();
        
        $data = array(
            'driver_status' => 2,
        );
        $where = array(
            'driver_id' => $id,
        );
        $this->common_model->update('driver', $data, $where);

        // 插入日志
        $log_remark = '删除司机，司机ID：<a href="'.site_url(''.$this->appfolder.'/driver/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(302, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/driver');
    }
}

?>