<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invite extends App_Web_Controller {

    public function index()
    {
        $this->data['title'] = '邀请';

        $invite_encode = $this->input->get('s');
        if (empty($invite_encode)) {
            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $invite_encode = base64_decode($invite_encode);
        $invite_decode = secret_string($invite_encode);

        $this->data['invite_decode'] = $invite_decode;

        $this->load->view($this->appfolder.'/invite_view', $this->data);
    }

    public function ajax_do_reg()
    {
        $error = array(
            'code' => 'success',
        );

        $mobile_phone = trim($this->input->post('mobile_phone', TRUE));
        $seccode = trim($this->input->post('seccode', TRUE));
        $password = $this->input->post('password');
        $invite_decode = $this->input->post('invite_decode', TRUE);

        $register_seccode = get_cookie($this->appfolder.'_invite_register_seccode');
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
            $error['code'] = '密码请输入6位或以上的数字或英文';
            echo json_encode($error);
            exit;
        }

        $where = array(
            'login_name' => $mobile_phone,
        );
        $driver_data = $this->driver_service->get_driver_data($where);
        if (!empty($driver_data)) {
            $error['code'] = '手机号码已经存在';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        // 写入司机信息
        $data = array(
            'driver_name' => $mobile_phone,
            'login_name' => $mobile_phone,
            'login_pwd' => $password,
            'driver_mobile' => $mobile_phone,
            'driver_score' => 10,
            'create_time' => $time,
        );
        $driver_id = $this->common_model->insert('driver', $data);
        if ($driver_id == 0) {
            $this->common_model->trans_rollback();

            $error['code'] = '司机信息写入失败';
            echo json_encode($error);
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

            $error['code'] = '车辆信息写入失败';
            echo json_encode($error);
            exit;
        }

        // 增加积分
        $rtn = $this->driver_service->update_driver_score($invite_decode, 6);
        if ($rtn === FALSE) {
            $error['code'] = '积分增加失败';
            echo json_encode($error);
            exit;
        }

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = '操作失败';
            echo json_encode($error);
            exit;
        }
        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }
}