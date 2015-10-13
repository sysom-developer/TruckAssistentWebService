<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle extends Admin_Controller {

    public function index()
    {
        $this->set_path('车辆列表');
        
        $per_page = 16;    // 每页显示数量
        $cur_num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;    // 当前页数量
        
        $where = array();
        
        $this->data['total'] = $this->common_model->get_count('vehicle', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['uri_segment'] = 4;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/vehicle/index');
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('vehicle', $where, $per_page, $cur_num, 'vehicle_id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as &$value) {
                $attachment_data = $this->attachment_service->get_attachment_by_id($value['vehicle_head_icon']);
                $value['vehicle_head_icon_http_file'] = $attachment_data['http_file'];

                $where = array(
                    'driver_id' => $value['driver_id'],
                );
                $value['driver_data'] = $this->driver_service->get_driver_data($where);

                $value['vehicle_type_data'] = $this->vehicle_service->get_vehicle_type_by_id($value['vehicle_type']);

                $value['vehicle_length_data'] = $this->vehicle_service->get_vehicle_length_by_id($value['vehicle_length']);

                $value['vehicle_load_data'] = $this->vehicle_service->get_vehicle_load_by_id($value['vehicle_load']);
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/vehicle/vehicle_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加车辆');

        $this->data['get_driver_options'] = $this->driver_service->get_driver_options();
        $this->data['get_vehicle_type_options'] = $this->vehicle_service->get_vehicle_type_options();
        $this->data['get_vehicle_length_options'] = $this->vehicle_service->get_vehicle_length_options();
        $this->data['get_vehicle_load_options'] = $this->vehicle_service->get_vehicle_load_options();
        
        $this->load->view(''.$this->appfolder.'/vehicle/add_vehicle_view', $this->data);
    }
    
    public function act_add_data()
    {
        $driver_id = $this->input->post('driver_id');
        $vehicle_card_num = $this->input->post('vehicle_card_num');
        $vehicle_engine = $this->input->post('vehicle_engine');
        $vehicle_head_icon_img_attachment_id = $this->input->post('vehicle_head_icon_img_attachment_id');
        $vehicle_type = $this->input->post('vehicle_type');
        $vehicle_width = $this->input->post('vehicle_width');
        $vehicle_length = $this->input->post('vehicle_length');
        $vehicle_height = $this->input->post('vehicle_height');
        $vehicle_load = $this->input->post('vehicle_load');
        $vehicle_vin = $this->input->post('vehicle_vin');
        $vehicle_status = $this->input->post('vehicle_status');

        $this->common_model->trans_begin();

        $vehicle_head_icon_attachment_id = '';
        if ($vehicle_head_icon_img_attachment_id) {
            $vehicle_head_icon_attachment_id = move_upload_file($vehicle_head_icon_img_attachment_id);
        }

        $time = time();

        $data = array(
            'driver_id' => $driver_id,
            'vehicle_card_num' => $vehicle_card_num,
            'vehicle_engine' => $vehicle_engine,
            'vehicle_head_icon' => $vehicle_head_icon_attachment_id,
            'vehicle_type' => $vehicle_type,
            'vehicle_width' => $vehicle_width,
            'vehicle_length' => $vehicle_length,
            'vehicle_height' => $vehicle_height,
            'vehicle_load' => $vehicle_load,
            'vehicle_vin' => $vehicle_vin,
            'vehicle_status' => $vehicle_status,
            'create_time' => date("Y-m-d H:i:s", $time),
        );
        $insert_id = $this->common_model->insert('vehicle', $data);

        // 插入日志
        $log_remark = '新增车辆，车辆ID：<a href="'.site_url(''.$this->appfolder.'/vehicle/edit_data/'.$insert_id.'').'">'.$insert_id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(310, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/vehicle');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑车辆');
        
        $this->data['id'] = $this->uri->rsegment(3);
        
        $where = array(
            'vehicle_id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('vehicle', $where)->row_array();

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['vehicle_head_icon']);
        $this->data['data']['vehicle_head_icon_http_file'] = $attachment_data['http_file'];

         $this->data['get_driver_options'] = $this->driver_service->get_driver_options(array(), $this->data['data']['driver_id']);
        $this->data['get_vehicle_type_options'] = $this->vehicle_service->get_vehicle_type_options($this->data['data']['vehicle_type']);
        $this->data['get_vehicle_length_options'] = $this->vehicle_service->get_vehicle_length_options($this->data['data']['vehicle_length']);
        $this->data['get_vehicle_load_options'] = $this->vehicle_service->get_vehicle_load_options($this->data['data']['vehicle_load']);
        
        $this->load->view(''.$this->appfolder.'/vehicle/edit_vehicle_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $driver_id = $this->input->post('driver_id');
        $vehicle_card_num = $this->input->post('vehicle_card_num');
        $vehicle_engine = $this->input->post('vehicle_engine');
        $vehicle_head_icon_img_attachment_id = $this->input->post('vehicle_head_icon_img_attachment_id');
        $vehicle_type = $this->input->post('vehicle_type');
        $vehicle_width = $this->input->post('vehicle_width');
        $vehicle_length = $this->input->post('vehicle_length');
        $vehicle_height = $this->input->post('vehicle_height');
        $vehicle_load = $this->input->post('vehicle_load');
        $vehicle_vin = $this->input->post('vehicle_vin');
        $vehicle_status = $this->input->post('vehicle_status');

        $this->common_model->trans_begin();

        $where = array(
            'vehicle_id' => $id,
        );
        $vehicle_data = $this->common_model->get_data('vehicle', $where)->row_array();

        $data = array(
            'driver_id' => $driver_id,
            'vehicle_card_num' => $vehicle_card_num,
            'vehicle_engine' => $vehicle_engine,
            'vehicle_type' => $vehicle_type,
            'vehicle_width' => $vehicle_width,
            'vehicle_length' => $vehicle_length,
            'vehicle_height' => $vehicle_height,
            'vehicle_load' => $vehicle_load,
            'vehicle_vin' => $vehicle_vin,
            'vehicle_status' => $vehicle_status,
        );

        $vehicle_head_icon_attachment_id = '';
        if ($vehicle_head_icon_img_attachment_id) {
            $vehicle_head_icon_attachment_id = move_upload_file($vehicle_head_icon_img_attachment_id, $vehicle_data['vehicle_head_icon']);
            $data['vehicle_head_icon'] = $vehicle_head_icon_attachment_id;
        }

        $where = array(
            'vehicle_id' => $id,
        );
        $this->common_model->update('vehicle', $data, $where);

        // 插入日志
        $log_remark = '编辑车辆，车辆ID：<a href="'.site_url(''.$this->appfolder.'/vehicle/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(311, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/vehicle');
    }
    
    public function delete()
    {
        $id = $this->uri->rsegment(3);

        $this->common_model->trans_begin();
        
        $data = array(
            'vehicle_status' => 2,
        );
        $where = array(
            'vehicle_id' => $id,
        );
        $this->common_model->update('vehicle', $data, $where);

        // 插入日志
        $log_remark = '删除车辆，车辆ID：<a href="'.site_url(''.$this->appfolder.'/vehicle/edit_data/'.$id.'').'">'.$id.'</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(312, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/vehicle');
    }
}

?>