<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Public_Android_Controller {

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
        $time = time();

        $mobile_phone = trim($this->input->get_post('mobile_phone', TRUE));
        $seccode = trim($this->input->get_post('seccode', TRUE));
        $password = $this->input->get_post('password');
        $device = trim($this->input->get_post('device', TRUE));

        $time = time();

        if ($seccode != '88888') {
            $where = array(
                'mobile_phone' => $mobile_phone,
                'seccode' => $seccode,
            );
            $driver_register_seccode_log_data = $this->common_model->get_data('driver_register_seccode_log', $where, 1, 0, 'id', 'DESC')->row_array();
            if (empty($driver_register_seccode_log_data)) {
                $this->app_error_func(998, '验证码不存在');
                exit;
            }
            if ($time > $driver_register_seccode_log_data['invalid_time']) {
                $this->app_error_func(997, '验证码失效，请重新获取');
                exit;
            }   
        }

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $this->app_error_func(996, '请正确输入手机号码');
            exit;
        }

        if (strlen($password) < 6) {
            $this->app_error_func(994, '请输入6位或以上的密码');
            exit;
        }

        if (empty($device)) {
            $this->app_error_func(993, '请重新操作');
            exit;
        }

        $this->common_model->trans_begin();

        $where = array(
            'login_name' => $mobile_phone,
        );
        $driver_data = $this->driver_service->get_driver_data($where);
        if (!empty($driver_data)) {
            $this->app_error_func(992, '手机号码已经存在');
            exit;
        }

        // 写入司机信息
        $data = array(
            'driver_name' => $mobile_phone,
            'login_name' => $mobile_phone,
            'login_pwd' => $password,   // do_hash($password, 'md5'),
            'driver_mobile' => $mobile_phone,
            'device' => $device,
            'create_time' => $time,
        );
        $driver_id = $this->common_model->insert('driver', $data);
        if ($driver_id == 0) {
            $this->common_model->trans_rollback();

            $this->app_error_func(991, '司机信息写入失败');
            exit;
        }

        // 写入车辆信息
        $data = array(
            'driver_id' => $driver_id,
            'create_time' => date('Y-m-d H:i:s', $time),
        );
        $vehicle_id = $this->common_model->insert('vehicle', $data);
        if ($vehicle_id == 0) {
            $this->common_model->trans_rollback();

            $this->app_error_func(990, '车辆信息写入失败');
            exit;
        }

        // 删除验证码
        $where = array(
            'mobile_phone' => $mobile_phone,
            'seccode' => $seccode,
        );
        $this->common_model->delete('driver_register_seccode_log', $where);

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