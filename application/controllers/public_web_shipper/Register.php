<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Public_MY_Controller {

    // 新注册用户
    public function index()
    {
        $this->data['title'] = '新注册用户';

        $this->load->view($this->appfolder.'/register_view', $this->data);
    }

    public function ajax_do_reg()
    {
        $error = array(
            'code' => 'success',
        );

        $mobile_phone = trim($this->input->post('mobile_phone', TRUE));
        $seccode = trim($this->input->post('seccode', TRUE));
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password', TRUE);
        $company_name = trim($this->input->post('company_name', TRUE));
        $company_address = trim($this->input->post('company_address', TRUE));

        $register_seccode = get_cookie($this->appfolder.'_register_seccode');
        $register_seccode = $this->encrypt->decode($register_seccode, $this->config->config['encryption_key']);
        $array = explode("_", $register_seccode);
        $register_seccode = $array[0];

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $error['code'] = '手机号码输入错误';
            echo json_encode($error);
            exit;
        }

        if (empty($seccode) || empty($register_seccode) || $seccode != $register_seccode) {
            $error['code'] = '验证码输入错误';
            echo json_encode($error);
            exit;
        }

        $pattern = '#^([A-Za-z0-9])+$#i';
        if (!preg_match($pattern, $password)) {
            $error['code'] = '请输入6位或以上的数字或英文';
            echo json_encode($error);
            exit;
        }
        if (!preg_match($pattern, $confirm_password)) {
            $error['code'] = '请输入6位或以上的数字或英文';
            echo json_encode($error);
            exit;
        }

        if (empty($company_name) || $company_name == '请输入公司名称') {
            $error['code'] = '请输入公司名称';
            echo json_encode($error);
            exit;
        }

        if (empty($company_address) || $company_address == '请输入公司地址') {
            $error['code'] = '请输入公司地址';
            echo json_encode($error);
            exit;
        }

        $where = array(
            'shipper_company_name' => $company_name,
        );
        $count = $this->common_model->get_count('shipper_company', $where);
        if ($count > 0) {
            $error['code'] = '公司名称已经存在';
            echo json_encode($error);
            exit;
        }

        $count = $this->db->from('shipper')
        ->or_where('shipper_name =', $mobile_phone)
        ->or_where('login_name =', $mobile_phone)
        ->or_where('shipper_mobile =', $mobile_phone)
        ->count_all_results();
        if ($count > 0) {
            $error['code'] = '手机号码已经存在';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_begin();

        $time = date('Y-m-d H:i:s', time());

        $data = array(
            'shipper_company_name' => $company_name,
            'shipper_company_addr' => $company_address,
            'create_time' => $time,
        );
        $company_id = $this->common_model->insert('shipper_company', $data);

        $data = array(
            'shipper_name' => $mobile_phone,
            'login_name' => $mobile_phone,
            'login_pwd' => $password,
            'shipper_mobile' => $mobile_phone,
            'company_id' => $company_id,
            'create_time' => $time,
        );
        $shipper_id = $this->common_model->insert('shipper', $data);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = 998;
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_commit();

        // 加密字符串
        $register_encode_string = 'yadgen|thy|' . $shipper_id . '|' . ($password);
        $register_encode_string = $this->encrypt->encode($register_encode_string, $this->config->config['encryption_key']);

        // 默认保存一年
        $expire = 356 * 86400;

        // 设置登陆cookie
        $cookie = array(
            'name' => $this->appfolder.'_shipper',
            'value' => $register_encode_string,
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

    // 已注册公司用户
    public function company_user()
    {
        $this->data['title'] = '已注册公司用户';

        $this->data['get_shipper_company_options'] = $this->shipper_company_service->get_shipper_company_options();

        $this->load->view($this->appfolder.'/register_company_user_view', $this->data);
    }

    public function ajax_do_reg_company()
    {
        $error = array(
            'code' => 'success',
        );

        $shipper_company_id = $this->input->post('shipper_company_id', TRUE);
        $manager_seccode = trim($this->input->post('manager_seccode', TRUE));
        $mobile_phone = trim($this->input->post('mobile_phone', TRUE));
        $seccode = trim($this->input->post('seccode', TRUE));
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password', TRUE);

        // 管理码
        $register_company_manager_seccode = get_cookie($this->appfolder.'_register_company_manager_seccode');
        $register_company_manager_seccode = $this->encrypt->decode($register_company_manager_seccode, $this->config->config['encryption_key']);
        $array = explode("_", $register_company_manager_seccode);
        $register_company_manager_seccode = $array[0];

        // 验证码
        $register_company_seccode = get_cookie($this->appfolder.'_register_company_seccode');
        $register_company_seccode = $this->encrypt->decode($register_company_seccode, $this->config->config['encryption_key']);
        $array = explode("_", $register_company_seccode);
        $register_company_seccode = $array[0];

        if (empty($manager_seccode) || empty($register_company_manager_seccode) || $manager_seccode != $register_company_manager_seccode) {
            $error['code'] = '管理码输入错误';
            echo json_encode($error);
            exit;
        }

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $mobile_phone)) {
            $error['code'] = '手机号码输入错误';
            echo json_encode($error);
            exit;
        }

        if (empty($seccode) || empty($register_company_seccode) || $seccode != $register_company_seccode) {
            $error['code'] = '验证码输入错误';
            echo json_encode($error);
            exit;
        }

        $pattern = '#^([A-Za-z0-9])+$#i';
        if (!preg_match($pattern, $password)) {
            $error['code'] = '请输入6位或以上的数字或英文';
            echo json_encode($error);
            exit;
        }
        if (!preg_match($pattern, $confirm_password)) {
            $error['code'] = '请输入6位或以上的数字或英文';
            echo json_encode($error);
            exit;
        }

        $count = $this->db->from('shipper')
        ->or_where('shipper_name =', $mobile_phone)
        ->or_where('login_name =', $mobile_phone)
        ->or_where('shipper_mobile =', $mobile_phone)
        ->count_all_results();
        if ($count > 0) {
            $error['code'] = '手机号码已经存在';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_begin();

        $time = date('Y-m-d H:i:s', time());

        $data = array(
            'shipper_name' => $mobile_phone,
            'login_name' => $mobile_phone,
            'login_pwd' => $password,
            'shipper_mobile' => $mobile_phone,
            'company_id' => $shipper_company_id,
            'create_time' => $time,
        );
        $shipper_id = $this->common_model->insert('shipper', $data);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = 998;
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_commit();

        // 加密字符串
        $register_encode_string = 'yadgen|thy|' . $shipper_id . '|' . ($password);
        $register_encode_string = $this->encrypt->encode($register_encode_string, $this->config->config['encryption_key']);

        // 默认保存一年
        $expire = 356 * 86400;

        // 设置登陆cookie
        $cookie = array(
            'name' => $this->appfolder.'_shipper',
            'value' => $register_encode_string,
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