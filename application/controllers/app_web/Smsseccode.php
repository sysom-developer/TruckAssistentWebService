<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Smsseccode extends App_Web_Controller {

    public function index()
    {
    }

    public function get_sms_seccode()
    {
        $error = array(
            'code' => 'success',
        );

        $mobile_phone = trim($this->input->post('mobile_phone', TRUE));
        $prefix = $this->input->post('prefix', TRUE);

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $error['code'] = '请正确输入手机号码';
            echo json_encode($error);
            exit;
        }

        $seccode = random_number(4);
        $content = $this->sms->buildAuthCodeMessage($seccode);
        $sms_rtn = $this->sms->sendSms($mobile_phone, $content);
        if (!$sms_rtn) {
            $error['code'] = '验证码发送失败';
            echo json_encode($error);
            exit;
        }

        $encode_string = $seccode."_".$mobile_phone;

        $cookie = array(
            'name' => $this->appfolder.'_'.$prefix.'_seccode',
            'value' => $this->encrypt->encode($encode_string, $this->config->config['encryption_key']),
            'expire' => 300,
            'path' => '/'.$this->appfolder,
        );
        $this->input->set_cookie($cookie);

        echo json_encode($error);
        exit;
    }
}