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
                    'description' => 'success',
                ),
            ),
            'body' => array(),
        );
    }

    /**
     * 注册
     */
    public function index()
    {
        $time = time();

        $mobile_phone = trim($this->input->get_post('mobile_phone', TRUE));
        $seccode = trim($this->input->get_post('seccode', TRUE));
        $password = $this->input->get_post('password');
        $device = trim($this->input->get_post('device', TRUE));

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

        //验证设备号
        if (empty($device)) {
            $this->app_error_func(1195, '请重新操作');
            exit;
        }



        //开始事务
        $this->common_model->trans_begin();

        $where = array(
            'login_name' => $mobile_phone,
        );

        //判断是否已存在
        $driver_data = $this->driver_service->get_driver_data($where);
        if (!empty($driver_data)) {
            $this->app_error_func(1194, '手机号码已经存在');
            exit;
        }

        // 写入司机信息
        $data = [
            'driver_name' => $mobile_phone,
            'login_name' => $mobile_phone,
            'login_pwd' => $password,   // do_hash($password, 'md5'),
            'driver_mobile' => $mobile_phone,
            'device' => $device,
            'create_time' => $time,
        ];
        $driver_id = $this->common_model->insert('driver', $data);
        if ($driver_id == 0) {//写入失败，回滚
            $this->common_model->trans_rollback();

            $this->app_error_func(1193, '司机信息写入失败');
            exit;
        }

        // 删除验证码
        $where = array(
            'mobile_phone' => $mobile_phone,
            'seccode' => $seccode,
        );
        $this->common_model->update('driver_register_seccode_log', array('is_deleted' => 1), $where);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(1191, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();


        echo json_en($this->data['error']);
        exit;
    }
}