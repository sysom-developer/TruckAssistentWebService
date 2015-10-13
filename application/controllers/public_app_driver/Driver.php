<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends Public_Android_Controller {

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
        
    }

    public function driver_join_company()
    {
        $company_id = $this->input->get_post('company_id');

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (!(is_numeric($company_id) && $company_id > 0)) {
            $this->app_error_func(997, 'company_id 参数错误');
            exit;
        }

        $where = array(
            'shipper_company_id' => $company_id,
            'driver_id' => $this->data['driver_id'],
        );
        $shipper_driver = $this->shipper_driver_service->get_shipper_driver_data($where);
        if ($shipper_driver) {
            $this->app_error_func(996, '已经加入该货运公司');
            exit;
        }

        $time = time();

        $data = array(
            'shipper_company_id' => $company_id,
            'driver_id' => $this->data['driver_id'],
            'create_time' => date('Y-m-d H:i:s', $time),
        );
        $insert_id = $this->common_model->insert('shipper_driver', $data);

        if ($insert_id > 0) {
            // 司机异常消息
            $data = array(
                'anomaly_type' => 2,
                'company_id' => $company_id,
                'driver_id' => $this->data['driver_id'],
                'exce_desc' => '已加入公司',
                'cretime' => $time,
            );
            $this->common_model->insert('driver_anomaly', $data);

            // 增加积分 - 是否首次加入公司
            $where = array(
                'company_id' => $company_id,
                'driver_id' => $this->data['driver_id'],
            );
            $driver_join_company_log_data_list = $this->driver_join_company_log_service->get_driver_join_company_log_data($where);
            if (empty($driver_join_company_log_data_list)) {
                // 增加积分
                $rtn = $this->driver_service->update_driver_score($this->data['driver_id'], 5);
                if ($rtn === FALSE) {
                    $this->app_error_func(666, '积分增加失败');
                    exit;
                }
                $this->data['error']['body'] = $rtn;
            }

            // 新增加入公司log
            $data = array(
                'company_id' => $company_id,
                'driver_id' => $this->data['driver_id'],
                'cretime' => $time,
            );
            $this->common_model->insert('driver_join_company_log', $data);

            echo json_en($this->data['error']);
            exit;
        } else {
            $this->app_error_func(999, '操作失败');
            exit;
        }
    }

    public function driver_quit_company()
    {
        $company_id = $this->input->get_post('company_id');

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (!(is_numeric($company_id) && $company_id > 0)) {
            $this->app_error_func(997, 'company_id 参数错误');
            exit;
        }

        $where = array(
            'shipper_company_id' => $company_id,
            'driver_id' => $this->data['driver_id'],
        );
        $shipper_driver = $this->shipper_driver_service->get_shipper_driver_data($where);
        if (empty($shipper_driver)) {
            $this->app_error_func(996, '没有加入该货运公司');
            exit;
        }

        $time = time();

        $where = array(
            'shipper_company_id' => $company_id,
            'driver_id' => $this->data['driver_id'],
        );
        $this->common_model->delete('shipper_driver', $where);

        // 司机异常消息
        $data = array(
            'anomaly_type' => 2,
            'company_id' => $company_id,
            'driver_id' => $this->data['driver_id'],
            'exce_desc' => '已退出公司',
            'cretime' => $time,
        );
        $this->common_model->insert('driver_anomaly', $data);

        echo json_en($this->data['error']);
        exit;
    }

    public function get_driver_address()
    {
        $address_type = $this->input->get_post('address_type', TRUE);

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (!(in_array($address_type, array(1, 2)))) {
            $this->app_error_func(997, 'address_type 参数错误');
            exit;
        }

        $where = array(
            'address_type' => $address_type,
            'driver_id' => $this->data['driver_id'],
        );
        $this->data['error']['body']['data_list'] = $this->driver_service->get_driver_address_data_list($where, '', '', 'count', 'DESC');

        echo json_en($this->data['error']);
        exit;
    }

    public function update_app_add_score()
    {
        $device = trim($this->input->get_post('device', TRUE));
        $pre_version = trim($this->input->get_post('pre_version', TRUE));
        $version = trim($this->input->get_post('version', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        $driver_data = $this->driver_service->get_driver_by_id($this->data['driver_id']);

        $where = array(
            'driver_id' => $this->data['driver_id'],
            'version' => $version,
        );
        $driver_update_log_data = $this->driver_update_log_service->get_driver_update_log_data($where);
        $is_add_score = FALSE;
        if (empty($driver_update_log_data)) {
            $is_add_score = TRUE;
        }

        // 新增升级历史纪录
        $data = array(
            'driver_id' => $this->data['driver_id'],
            'prev_device' => $driver_data['device'],
            'device' => $device,
            'pre_version' => $pre_version,
            'version' => $version,
            'cretime' => $time,
        );
        $this->common_model->insert('driver_update_log', $data);

        // 增加积分
        $rtn = '';
        if ($is_add_score === TRUE) {
            $rtn = $this->driver_service->update_driver_score($this->data['driver_id'], 4);
        }

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        $this->data['error']['body'] = $rtn;

        echo json_en($this->data['error']);
        exit;
    }

    public function get_invite_url()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $invite_encode = string_secret($this->data['driver_id']);
        $invite_encode = base64_encode($invite_encode);

        $this->data['error']['body']['invite_url'] = site_url('app_web/invite/?s='.$invite_encode);

        echo json_en($this->data['error']);
        exit;
    }

    public function update_device()
    {
        $device = $this->input->get_post('device', TRUE);

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (empty($device)) {
            $this->app_error_func(997, 'device 参数错误');
            exit;
        }

        // 更新司机当前设备号
        $data = array(
            'device' => $device,
        );
        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        $this->common_model->update('driver', $data, $where);

        echo json_en($this->data['error']);
        exit;
    }

    public function get_driver_score_history()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        $driver_score_log_data_list = $this->driver_score_log_service->get_driver_score_log_data_list($where);
        $data_list = array();
        if ($driver_score_log_data_list) {
            $this->load->config('driver_score_config');
            $driver_score_config = $this->config->item('driver_score_config');

            foreach ($driver_score_log_data_list as $value) {
                $score_desc = '兑换积分商品';
                $handle = '-';
                if ($value['set_type'] > 0) {
                    $score_desc = $driver_score_config[$value['set_type']]['score_desc'];
                    $handle = '+';
                }

                $data_list[] = array(
                    'handle' => $handle,
                    'score_desc' => $score_desc,
                    'cretime' => date('m-d H:i', $value['cretime']),
                    'score_num' => $value['score_num'],
                );
            }
        }

        $this->data['error']['body']['data_list'] = $data_list;
        echo json_en($this->data['error']);
        exit;
    }

    public function exchange_product_score()
    {
        $id = intval($this->input->get_post('id', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (!($id > 0)) {
            $this->app_error_func(997, 'id 参数错误');
            exit;
        }

        $where = array(
            'id' => $id,
        );
        $product_score_data = $this->product_score_service->get_product_score_by_id($id);
        if (empty($product_score_data)) {
            $this->app_error_func(996, 'id 参数错误');
            exit;
        }

        if ($this->data['driver_data']['driver_score'] < $product_score_data['exchange_num']) {
            $this->app_error_func(995, '当前积分不够');
            exit;
        }

        $this->common_model->trans_begin();

        $time = time();

        $data = array(
            'product_score_id' => $id,
            'driver_id' => $this->data['driver_id'],
            'exchange_num' => $product_score_data['exchange_num'],
            'cretime' => $time,
        );
        $this->common_model->insert('driver_exchange_product_score_log', $data);

        $this->driver_service->exchange_driver_score($this->data['driver_id'], $product_score_data['exchange_num']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }

    public function exchange_log()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        $data_list = $this->driver_exchange_product_score_log_service->get_driver_exchange_product_score_log_data_list($where);

        $rtn_data_list = array();
        if ($data_list) {
            foreach ($data_list as &$value) {
                $product_score_data = $this->product_score_service->get_product_score_by_id($value['product_score_id']);
                $rtn_data_list[] = array(
                    'exchange_desc' => '成功兑换 '.$product_score_data['product_name'],
                    'cretime' => date('m-d H:i', $value['cretime']),
                );
            }
        }

        $this->data['error']['body']['data_list'] = $rtn_data_list;
        echo json_en($this->data['error']);
        exit;
    }

    public function get_company_stat()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        // 加入时间
        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        $shipper_driver_data = $this->shipper_driver_service->get_shipper_driver_data($where);
        if (empty($shipper_driver_data['create_time'])) {
            $this->app_error_func(998, '记录不存在');
            exit;
        }
        $join_time = date('Y年m月d日', strtotime($shipper_driver_data['create_time']));

        // 运输次数
        $where = array(
            'driver_id' => $this->data['driver_id'],
            'order_type' => 5,
        );
        $finished_order_count = $this->orders_service->get_orders_count($where);

        // 公司给我的评价
        $company_comment_me = 4;

        $this->data['error']['body']['join_time'] = $join_time;
        $this->data['error']['body']['finished_order_count'] = $finished_order_count;
        $this->data['error']['body']['company_comment_me'] = $company_comment_me;

        echo json_en($this->data['error']);
        exit;
    }
}