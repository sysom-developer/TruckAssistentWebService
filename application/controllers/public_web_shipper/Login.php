<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Public_MY_Controller {

    public function index()
    {
        $this->data['title'] = '登陆';

        $this->load->view($this->appfolder.'/login_view', $this->data);
    }

    public function ajax_do_login()
    {
        $error = array(
            'code' => 'success',
        );

        $login_name = trim($this->input->post('login_name', TRUE));
        $login_pwd = $this->input->post('login_pwd');
        $remember_auto_login = $this->input->post('remember_auto_login', TRUE);

        $where = array(
            'login_name' => $login_name,
            'login_pwd' => $login_pwd,
        );
        $shipper_data = $this->shipper_service->get_shipper_data($where);
        if (!$shipper_data) {
            $error['code'] = '账号或密码输入错误';
            echo json_encode($error);
            exit;
        }
        $shipper_id = $shipper_data['shipper_id'];
        $password = $login_pwd;

        // 加密字符串
        $login_encode_string = 'yadgen|thy|' . $shipper_id . '|' . ($password);
        $login_encode_string = $this->encrypt->encode($login_encode_string, $this->config->config['encryption_key']);

        // 自动登陆
        $expire = 0;
        if ($remember_auto_login == 1) {
            $expire = 356 * 86400;
        }

        // 设置登陆cookie
        $cookie = array(
            'name' => $this->appfolder.'_shipper',
            'value' => $login_encode_string,
            'expire' => $expire,
            'path' => '/'.$this->appfolder,
        );
        $this->input->set_cookie($cookie);

        // 设置session
        $session_data = array(
            $this->appfolder.'_shipper_id' => $shipper_id,
        );
        $this->session->set_userdata($session_data);

        echo json_encode($error);
        exit;
    }
}