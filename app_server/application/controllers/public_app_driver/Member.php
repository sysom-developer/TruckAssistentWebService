<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => 'success',
                ),
            ),
            'body' => array(),
        );
    }

    public function index()
    {
        
    }


    public function update_personal_info()
    {
        $driver_name = trim($this->input->get_post('driver_name', TRUE));
        $driver_sex = trim($this->input->get_post('driver_sex', TRUE));
        $driver_province = intval($this->input->get_post('driver_province', TRUE));
        $driver_city = intval($this->input->get_post('driver_city', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(1899, 'driver_id 参数错误');
            exit;
        }

        if (empty($driver_name)) {
            $this->app_error_func(1898, '名字不可为空');
            exit;
        }

        if (!in_array($driver_sex, array('男', '女'))) {
            $this->app_error_func(1897, '性别错误');
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'driver_name' => $driver_name,
            'driver_sex' => $driver_sex,
            'driver_province' => $driver_province,
            'driver_city' => $driver_city,
        );

        $driver_head_icon_attachment_id = '';
        $driver_head_icon_upload_data = upload_img_file('driver_head_icon', 'driver_head_icon_img');
        if ($driver_head_icon_upload_data['status'] != -1) {
            $filepath = substr($driver_head_icon_upload_data['data']['file_path'], stripos($driver_head_icon_upload_data['data']['file_path'], "data_tmp"));
            $attachment_data = array(
                'filetype' => $driver_head_icon_upload_data['data']['file_type'],
                'filename' => $driver_head_icon_upload_data['data']['file_name'],
                'filesize' => $driver_head_icon_upload_data['data']['file_size'],
                'filepath' => $filepath,
            );
            $driver_head_icon_img_attachment_id = $this->common_model->insert('attachment_tmp', $attachment_data);
            $driver_head_icon_attachment_id = move_upload_file($driver_head_icon_img_attachment_id);
            $data['driver_head_icon'] = $driver_head_icon_attachment_id;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        $this->common_model->update('driver', $data, $where);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(1896, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }

    public function binding_obd(){

        $obd_device_no = trim($this->input->get_post('obd_device_no', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(1399, 'driver_id 参数错误');
            exit;
        }

        if (empty($obd_device_no)) {
            $this->app_error_func(6666, '输入obd设备号');
            exit;
        }

        $where = [
            'driver_id' => $this->data['driver_id']
        ];

        $data = [
            'obd_device_no' => $obd_device_no,
        ];

        $this->common_model->update('obd_device', $data, $where);

        echo json_en($this->data['error']);
        exit;
    }

    public function unbinding_obd(){

        $obd_device_no = trim($this->input->get_post('obd_device_no', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(1399, 'driver_id 参数错误');
            exit;
        }

        if (empty($obd_device_no)) {
            $this->app_error_func(6666, '输入obd设备号');
            exit;
        }

        $where = [
            'driver_id' => $this->data['driver_id']
        ];

        $data = [
            'obd_device_no' => $obd_device_no,
        ];

        $this->common_model->update('obd_device', $data, $where);

        echo json_en($this->data['error']);
        exit;
    }

    public function update_info()
    {
        $vehicle_card_num = trim($this->input->get_post('vehicle_card_num', TRUE));
        $vehicle_type = intval($this->input->get_post('vehicle_type', TRUE));
        $vehicle_load = intval($this->input->get_post('vehicle_load', TRUE));
        $vehicle_length = intval($this->input->get_post('vehicle_length', TRUE));
        $obd_device_no = trim($this->input->get_post('obd_device_no', TRUE));
        //后桥速比
        $rear_axle_ratio = trim($this->input->get_post('rear_axle_ratio', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(1399, 'driver_id 参数错误');
            exit;
        }

        if (empty($vehicle_type)) {
            $this->app_error_func(1397, '请选择车辆类型');
            exit;
        }

        if (empty($vehicle_load)) {
            $this->app_error_func(1396, '请选择车辆载重');
            exit;
        }

        if (empty($vehicle_length)) {
            $this->app_error_func(1395, '请选择车辆长度');
            exit;
        }
        if (empty($vehicle_length)) {
            $this->app_error_func(1395, '请选择车辆长度');
            exit;
        }

        if (empty($rear_axle_ratio)) {
            $this->app_error_func(1394, '请选择车辆后桥速比');
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        $where = [
            'driver_id' => $this->data['driver_id']
        ];

        // 更新司机信息
        $data = [
            'is_vehicle_perfect' => 1,
        ];
        $this->common_model->update('driver', $data, $where);


        //车辆记录是否存在
        $vehicle_data = $this->vehicle_service->get_vehicle_data($where);
        $data = [
            'vehicle_type' => $vehicle_type,
            'vehicle_load' => $vehicle_load,
            'vehicle_length' => $vehicle_length,
            'rear_axle_ratio' => $rear_axle_ratio
        ];
        if (!empty($vehicle_card_num)) {
            $data['vehicle_card_num'] = $vehicle_card_num;
        }

        if ($vehicle_data) {
            $this->common_model->update('vehicle', $data, $where);
        } else {
            $data['driver_id'] = $this->data['driver_id'];
            $data['create_time'] = date('Y-m-d H:i:s', $time);

            $this->common_model->insert('vehicle', $data);
        }


        if(!empty($obd_device_no)){
            //obd设备记录是否存在
            $odb_device_data = $this->obd_device_service->get_obd_device_data($where);
            $data = [
                'obd_device_no' => $obd_device_no,
            ];
            if ($odb_device_data) {
                $this->common_model->update('obd_device', $data, $where);
            } else {
                $data['driver_id'] = $this->data['driver_id'];
                $data['create_time'] = date('Y-m-d H:i:s', $time);
                $this->common_model->insert('obd_device', $data);
            }
        }



        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(1394, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 更新密码
     */
    public function update_pwd(){

        $mobile_phone = trim($this->input->get_post('mobile_phone', TRUE));
        $seccode = trim($this->input->get_post('seccode', TRUE));
        $password = $this->input->get_post('password');

        $time = time();

        //验证验证码
        if ($seccode != '88888') {
            $where = array(
                'mobile_phone' => $mobile_phone,
                'seccode' => $seccode,
                'is_deleted' => '0',
            );
            $driver_register_seccode_log_data = $this->common_model->get_data('driver_register_seccode_log', $where, 1, 0, 'id', 'DESC')->row_array();
            if (empty($driver_register_seccode_log_data)) {
                $this->app_error_func(1199, '验证码不存在');
                exit;
            }
            if ($time > $driver_register_seccode_log_data['invalid_time']) {
                $this->app_error_func(1198, '验证码失效，请重新获取');
                exit;
            }
        }

        //验证手机号码
        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $this->app_error_func(1197, '请正确输入手机号码');
            exit;
        }

        //验证密码
        if (strlen($password) < 6) {
            $this->app_error_func(1196, '请输入6位或以上的密码');
            exit;
        }

        $where = array(
            'login_name' => $mobile_phone,
        );

        // 写入司机信息
        $data = [
            'login_pwd' => $password,   // do_hash($password, 'md5'),
        ];

        $this->common_model->update('driver', $data);

        // 删除验证码
        $where = array(
            'mobile_phone' => $mobile_phone,
            'seccode' => $seccode,
        );

        echo json_en($this->data['error']);
        exit;
    }

}