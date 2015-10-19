<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Public_Android_Controller {

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

    /**
     * 登录
     */
    public function index()
    {
        $mobile_phone = trim($this->input->get_post('mobile_phone', TRUE));
        $password = $this->input->get_post('password');
        $device = trim($this->input->get_post('device', TRUE));
        $model = trim($this->input->get_post('model', TRUE));
        $version = trim($this->input->get_post('version', TRUE));


        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $this->app_error_func(998, '请正确输入手机号码');
            exit;
        }

        if (strlen($password) < 6) {
            $this->app_error_func(997, '请输入6位或以上的密码');
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();



        //校验手机
        $where = array(
            'login_name' => $mobile_phone,
        );
        $driver_data = $this->driver_service->get_driver_data($where);
        if (empty($driver_data)) {
            $this->app_error_func(996, '手机号码输入错误');
            exit;
        }

        //校验手机密码
        $where = array(
            'login_name' => $mobile_phone,
            'login_pwd' => $password,    // do_hash($password, 'md5'),
        );
        $driver_data = $this->driver_service->get_driver_data($where);
        if (empty($driver_data)) {
            $this->app_error_func(996, '密码输入错误');
            exit;
        }

        $is_write_device_history = ($device == $driver_data['device']) ? FALSE : TRUE;
        //司机历史登录使用手机
        if ($is_write_device_history === TRUE) {
            $data = array(
                'driver_id' => $driver_data['driver_id'],
                'device_name' => $device,
                'model_name' => $model,
                'version_name' => $model,
                'cretime' => $time,
            );
            $this->common_model->insert('device_history', $data);
        }

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();


        //成功登陆返回司机信息
        $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_head_icon']);
        $driver_data['driver_head_icon'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_card_icon']);
        $driver_data['driver_card_icon'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_license_icon']);
        $driver_data['driver_license_icon'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_vehicle_license_icon']);
        $driver_data['driver_vehicle_license_icon'] = $attachment_data['http_file'];

        $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_pic']);
        $driver_data['driver_pic'] = $attachment_data['http_file'];
        
        $driver_data['driver_name'] = $driver_data['login_name'];
        $driver_data['driver_nick_name'] = $driver_data['login_name'];

        $this->data['error']['body']['user'] = $driver_data;

        echo json_en($this->data['error']);
        exit;
    }
}
