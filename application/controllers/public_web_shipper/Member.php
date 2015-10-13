<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Public_MY_Controller {

    public function index()
    {
        $this->data['title'] = '会员中心首页';

        $this->load->view($this->appfolder.'/member_view', $this->data);
    }

    public function my_score()
    {
        $this->data['title'] = '我的积分';

        $this->load->view($this->appfolder.'/member_my_score_view', $this->data);
    }

    public function score_product()
    {
        $this->data['title'] = '我要兑换';

        $this->load->view($this->appfolder.'/member_score_product_view', $this->data);
    }

    public function score_history()
    {
        $this->data['title'] = '积分明细';

        $where = array(
            'shipper_company_id' => $this->shipper_info['company_id'],
        );
        $this->data['data_list'] = $this->shipper_company_score_log_service->get_shipper_company_score_log_data_list($where);
        if ($this->data['data_list']) {
            $this->load->config('shipper_company_score_config');
            $shipper_company_score_config = $this->config->item('shipper_company_score_config');
            foreach ($this->data['data_list'] as &$value) {
                $value['score_desc'] = $shipper_company_score_config[$value['set_type']];
            }
        }

        $this->load->view($this->appfolder.'/member_score_history_view', $this->data);
    }

    public function exchange_score_product_history()
    {
        $this->data['title'] = '兑换记录';

        $this->load->view($this->appfolder.'/member_exchange_score_product_history_view', $this->data);
    }

    public function score_rule()
    {
        $this->data['title'] = '奖励规则';

        $this->load->view($this->appfolder.'/member_score_rule_view', $this->data);
    }

    public function my_qrcode()
    {
        $this->data['title'] = '我的二维码';

        require_once FCPATH.'application/libraries/qrcode/phpqrcode.php';

        $qrcode_data = $this->shipper_info['company_id']."-".$this->shipper_info['shipper_company_data']['shipper_company_name'];
        $errorCorrectionLevel = 'H';
        $matrixPointSize = 10;

        $PNG_TEMP_DIR = FCPATH.'data/company_qrcode_img/';
        $this->data['filename'] = $PNG_TEMP_DIR.$this->shipper_info['company_id'].'_'.md5($qrcode_data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($qrcode_data, $this->data['filename'], $errorCorrectionLevel, $matrixPointSize, 2);
        $this->data['filename'] = static_url('data/company_qrcode_img/'.basename($this->data['filename']));

        $this->load->view($this->appfolder.'/member_my_qrcode_view', $this->data);
    }

    public function member_publish()
    {
        $this->data['title'] = '添加员工';

        $this->load->view($this->appfolder.'/member_publish_view', $this->data);
    }

    public function ajax_do_member_publish()
    {
        $error = array(
            'code' => 'success',
        );

        $login_name = trim($this->input->post('login_name', TRUE));
        $password = $this->input->post('password');
        $company_id = $this->input->post('company_id');

        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $login_name)) {
            $error['code'] = '手机号码输入错误';
            echo json_encode($error);
            exit;
        }

        $pattern = '#^([A-Za-z0-9])+$#i';
        if (!preg_match($pattern, $password)) {
            $error['code'] = '请输入6位或以上的数字或英文';
            echo json_encode($error);
            exit;
        }

        $count = $this->db->from('shipper')
        ->or_where('shipper_name =', $login_name)
        ->or_where('login_name =', $login_name)
        ->or_where('shipper_mobile =', $login_name)
        ->count_all_results();
        if ($count > 0) {
            $error['code'] = '手机号码已经存在';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_begin();

        $time = date('Y-m-d H:i:s', time());

        $data = array(
            'shipper_name' => $login_name,
            'login_name' => $login_name,
            'login_pwd' => $password,
            'shipper_mobile' => $login_name,
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

        echo json_encode($error);
        exit;
    }

    public function setting()
    {
        $this->data['title'] = '修改个人资料';

        $this->load->view($this->appfolder.'/member_setting_view', $this->data);
    }

    public function ajax_do_setting()
    {
        $error = array(
            'code' => 'success',
        );

        // $login_name = trim($this->input->post('login_name', TRUE));
        $shipper_name = trim($this->input->post('shipper_name', TRUE));
        $former_password = $this->input->post('former_password', TRUE);
        $password = $this->input->post('password', TRUE);
        $confirm_password = $this->input->post('confirm_password', TRUE);
        $shipper_company_addr = trim($this->input->post('shipper_company_addr', TRUE));
        $shipper_company_desc = trim($this->input->post('shipper_company_desc', TRUE));

        $shipper_head_icon_img_attachment_id = $this->input->post('shipper_head_icon_img_attachment_id');

        // $pattern = '#^([A-Za-z0-9]){4,}$#';
        // if (!preg_match($pattern, $login_name)) {
        //     $error['code'] = '登录名请输入4位或以上字母或数字组合';
        //     echo json_encode($error);
        //     exit;
        // }

        // $where = array(
        //     'login_name' => $login_name,
        //     'shipper_id !=' => $this->shipper_info['shipper_id'],
        // );
        // $count = $this->common_model->get_count('shipper', $where);
        // if ($count > 0) {
        //     $error['code'] = '登录名已经存在';
        //     echo json_encode($error);
        //     exit;
        // }

        if (empty($shipper_name)) {
            $error['code'] = '请输入呢称';
            echo json_encode($error);
            exit;
        }

        if (empty($shipper_company_addr)) {
            $error['code'] = '请输入公司地址';
            echo json_encode($error);
            exit;
        }

        if (empty($shipper_company_desc)) {
            $error['code'] = '请输入公司简介';
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_begin();

        $data = array(
            // 'login_name' => $login_name,
            'shipper_name' => $shipper_name,
        );

        $where = array(
            'shipper_id' => $this->shipper_info['shipper_id'],
        );
        $shipper_data = $this->shipper_service->get_shipper_data($where);

        if (!(empty($former_password) && empty($password) && empty($confirm_password))) {
            $where = array(
                'shipper_id' => $this->shipper_info['shipper_id'],
                'login_pwd' => $former_password,
            );
            $shipper_data = $this->shipper_service->get_shipper_data($where);
            if (!$shipper_data) {
                $this->common_model->trans_rollback();
                $error['code'] = '当前密码输入错误';
                echo json_encode($error);
                exit;
            }

            $pattern = '#^([A-Za-z0-9])+$#i';
            if (!preg_match($pattern, $password)) {
                $this->common_model->trans_rollback();
                $error['code'] = '新密码请输入6位或以上的数字或英文';
                echo json_encode($error);
                exit;
            }
            if (!preg_match($pattern, $confirm_password)) {
                $this->common_model->trans_rollback();
                $error['code'] = '确认新密码请输入6位或以上的数字或英文';
                echo json_encode($error);
                exit;
            }

            $data['login_pwd'] = $password;
        }

        $shipper_head_icon_attachment_id = '';
        if ($shipper_head_icon_img_attachment_id) {
            $shipper_head_icon_attachment_id = move_upload_file($shipper_head_icon_img_attachment_id, $shipper_data['shipper_head_icon']);

            $data['shipper_head_icon'] = $shipper_head_icon_attachment_id;
        }

        $where = array(
            'shipper_id' => $this->shipper_info['shipper_id'],
        );
        $this->common_model->update('shipper', $data, $where);

        // 更新公司信息
        $data = array(
            'shipper_company_addr' => $shipper_company_addr,
            'shipper_company_desc' => $shipper_company_desc,
        );
        $where = array(
            'id' => $this->shipper_info['company_id'],
        );
        $this->common_model->update('shipper_company', $data, $where);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $error['code'] = 998;
            echo json_encode($error);
            exit;
        }

        $this->common_model->trans_commit();

        echo json_encode($error);
        exit;
    }
}