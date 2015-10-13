<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forget_pwd extends MY_Controller {

    public function index()
    {
        $this->data['title'] = '忘记密码';

        $this->load->view($this->appfolder.'/forget_pwd_view', $this->data);
    }

    public function reset_password()
    {
        $error = array(
            'code' => 'success',
        );

        $mobile_phone = trim($this->input->post('mobile_phone', TRUE));
        $seccode = $this->input->post('seccode', TRUE);
        $password = $this->input->post('password');

        $forget_pwd_seccode = get_cookie($this->appfolder.'_forget_pwd_seccode');
        $forget_pwd_seccode = $this->encrypt->decode($forget_pwd_seccode, $this->config->config['encryption_key']);
        $array = explode("_", $forget_pwd_seccode);
        $forget_pwd_seccode = $array[0];

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $error['code'] = '手机号码输入错误';
            echo json_encode($error);
            exit;
        }

        if (empty($seccode) || empty($forget_pwd_seccode) || $seccode != $forget_pwd_seccode) {
            $error['code'] = '验证码输入错误';
            echo json_encode($error);
            exit;
        }

        $data = array(
            'login_pwd' => $password,
        );
        $where = array(
            'login_name' => $mobile_phone,
        );
        $this->common_model->update('shipper', $data, $where);

        echo json_encode($error);
        exit;
    }
}