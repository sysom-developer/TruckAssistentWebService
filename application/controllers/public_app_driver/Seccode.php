<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seccode extends Public_Android_Controller {

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

    public function get_sms_seccode()
    {
        $mobile_phone = trim($this->input->get_post('mobile_phone', TRUE));

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $this->app_error_func(998, '请正确输入手机号码');
            exit;
        }

        $seccode = random_number(4);
        $content = $this->sms->buildAuthCodeMessage($seccode, 1);
        $sms_rtn = $this->sms->sendSms($mobile_phone, $content);
        if (!$sms_rtn) {
            $this->app_error_func(997, '验证码发送失败');
            exit;
        }

        $time = time();

        $data = array(
            'mobile_phone' => $mobile_phone,
            'seccode' => $seccode,
            'invalid_time' => $time + 300,
            'cretime' => $time,
        );
        $this->common_model->insert('driver_register_seccode_log', $data);

        echo json_en($this->data['error']);
        exit;
    }
}