<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Smsseccode extends MY_Controller {

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

    public function ajax_verify_sms_seccode()
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

        $seccode = trim($this->input->post('seccode', TRUE));
        $register_seccode = get_cookie($this->appfolder.'_'.$prefix.'_seccode');
        $register_seccode = $this->encrypt->decode($register_seccode, $this->config->config['encryption_key']);
        $array = explode("_", $register_seccode);
        $register_seccode = $array[0];
        if (empty($seccode) || empty($register_seccode) || $seccode != $register_seccode) {
            $error = array(
                'code' => '验证码输入错误',
            );
            echo json_encode($error);
            exit;
        }

        echo json_encode($error);
        exit;
    }

    public function get_manager_seccode()
    {
        $error = array(
            'code' => 'success',
        );

        $company_id = $this->input->post('company_id', TRUE);
        $prefix = $this->input->post('prefix', TRUE);

        $where = array(
            'company_id' => $company_id,
            'is_admin' => 1,
        );
        $shipper_data = $this->shipper_service->get_shipper_data($where);
        if (!$shipper_data) {
            $error['code'] = '没有公司账户，请联系管理员';
            echo json_encode($error);
            exit;
        }
        $error['shipper_name'] = $shipper_data['shipper_name'];

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $shipper_data['shipper_mobile'])) {
            $error['code'] = '非法手机号码，请联系管理员';
            echo json_encode($error);
            exit;
        }
        $error['shipper_mobile'] = $shipper_data['shipper_mobile'];

        $seccode = random_number(4);
        $content = $this->sms->buildAuthCodeMessage($seccode);
        $sms_rtn = $this->sms->sendSms($shipper_data['shipper_mobile'], $content);
        if (!$sms_rtn) {
            $error['code'] = '验证码发送失败';
            echo json_encode($error);
            exit;
        }

        $encode_string = $seccode."_".$shipper_data['shipper_mobile'];

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