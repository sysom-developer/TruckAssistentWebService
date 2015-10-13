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
                    'description' => '',
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
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (empty($driver_name)) {
            $this->app_error_func(997, '名字不可为空');
            exit;
        }

        if (!in_array($driver_sex, array('男', '女'))) {
            $this->app_error_func(996, '性别错误');
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

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }

    public function update_info()
    {
        $vehicle_card_num = trim($this->input->get_post('vehicle_card_num', TRUE));
        $vehicle_type = intval($this->input->get_post('vehicle_type', TRUE));
        $vehicle_load = intval($this->input->get_post('vehicle_load', TRUE));
        $vehicle_length = intval($this->input->get_post('vehicle_length', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (empty($vehicle_card_num)) {
            $this->app_error_func(998, '请输入车牌号码');
            exit;
        }

        if (empty($vehicle_type)) {
            $this->app_error_func(997, '请选择车辆类型');
            exit;
        }

        if (empty($vehicle_load)) {
            $this->app_error_func(996, '请选择车辆载重');
            exit;
        }

        if (empty($vehicle_length)) {
            $this->app_error_func(995, '请选择车辆长度');
            exit;
        }

        $driver_license_icon_attachment_id = '';
        $driver_license_icon_upload_data = upload_img_file('driver_license_icon', 'driver_license_icon_img');
        if ($driver_license_icon_upload_data['status'] != -1) {
            $filepath = substr($driver_license_icon_upload_data['data']['file_path'], stripos($driver_license_icon_upload_data['data']['file_path'], "data_tmp"));
            $data = array(
                'filetype' => $driver_license_icon_upload_data['data']['file_type'],
                'filename' => $driver_license_icon_upload_data['data']['file_name'],
                'filesize' => $driver_license_icon_upload_data['data']['file_size'],
                'filepath' => $filepath,
            );
            $driver_license_icon_img_attachment_id = $this->common_model->insert('attachment_tmp', $data);
            $driver_license_icon_attachment_id = move_upload_file($driver_license_icon_img_attachment_id);
        }
        
        $driver_vehicle_license_icon_attachment_id = '';
        $driver_vehicle_license_icon_upload_data = upload_img_file('driver_vehicle_license_icon', 'driver_vehicle_license_icon_img');
        if ($driver_vehicle_license_icon_upload_data['status'] != -1) {
            $filepath = substr($driver_vehicle_license_icon_upload_data['data']['file_path'], stripos($driver_vehicle_license_icon_upload_data['data']['file_path'], "data_tmp"));
            $data = array(
                'filetype' => $driver_vehicle_license_icon_upload_data['data']['file_type'],
                'filename' => $driver_vehicle_license_icon_upload_data['data']['file_name'],
                'filesize' => $driver_vehicle_license_icon_upload_data['data']['file_size'],
                'filepath' => $filepath,
            );
            $driver_vehicle_license_icon_img_attachment_id = $this->common_model->insert('attachment_tmp', $data);
            $driver_vehicle_license_icon_attachment_id = move_upload_file($driver_vehicle_license_icon_img_attachment_id);
        }

        $this->common_model->trans_begin();

        $time = time();

        $where = array(
            'driver_id' => $this->data['driver_id']
        );

        // 更新司机信息
        $data = array(
            'driver_type' => 2,
        );
        if (!empty($driver_license_icon_attachment_id)) {
            $data['driver_license_icon'] = $driver_license_icon_attachment_id;
        }
        if (!empty($driver_vehicle_license_icon_attachment_id)) {
            $data['driver_vehicle_license_icon'] = $driver_vehicle_license_icon_attachment_id;
        }
        $this->common_model->update('driver', $data, $where);

        // 记录是否存在
        $vehicle_data = $this->vehicle_service->get_vehicle_data($where);

        $data = array(
            'vehicle_card_num' => $vehicle_card_num,
            'vehicle_type' => $vehicle_type,
            'vehicle_load' => $vehicle_load,
            'vehicle_length' => $vehicle_length,
        );
        if ($vehicle_data) {
            $this->common_model->update('vehicle', $data, $where);
        } else {
            $data['driver_id'] = $this->data['driver_id'];
            $data['create_time'] = date('Y-m-d H:i:s', $time);

            $this->common_model->insert('vehicle', $data);
        }

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }

    public function add_report()
    {
        $device = $this->input->get_post('device', TRUE);
        $content = trim($this->input->get_post('content', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'driver_id' => $this->data['driver_id'],
            'device' => $device,
            'content' => $content,
            'cretime' => $time,
        );
        $this->common_model->insert('report', $data);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }

    public function reset_password()
    {
        $mobile_phone = trim($this->input->get_post('mobile_phone', TRUE));
        $seccode = trim($this->input->get_post('seccode', TRUE));
        $password = $this->input->get_post('password');

        $register_seccode = get_cookie($this->appfolder.'_register_seccode');
        $register_seccode = $this->encrypt->decode($register_seccode, $this->config->config['encryption_key']);
        $array = explode("_", $register_seccode);
        $register_seccode = $array[0];

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $this->app_error_func(998, '请正确输入手机号码');
            exit;
        }

        if (empty($seccode) || empty($register_seccode) || $seccode != $register_seccode) {
            $this->app_error_func(997, '验证码输入错误');
            exit;
        }

        if (strlen($password) < 6) {
            $this->app_error_func(996, '请输入6位或以上的密码');
            exit;
        }

        $this->common_model->trans_begin();

        $data = array(
            'login_pwd' => do_hash($password, 'md5'),
        );
        $where = array(
            'login_name' => $mobile_phone,
            'driver_mobile' => $mobile_phone,
        );
        $this->common_model->update('driver', $data, $where);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }
}