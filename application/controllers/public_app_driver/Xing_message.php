<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xing_message extends Public_Android_Controller {

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

    public function get_driver_message()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
            'title' => 'public_driver_message',
        );
        $this->data['error']['body']['data_list'] = $this->driver_message_service->get_driver_message_data_list($where);

        echo json_en($this->data['error']);
        exit;
    }

    public function delete_all_driver_message()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
            'title' => 'public_driver_message',
        );
        $this->common_model->delete('driver_message', $where);

        echo json_en($this->data['error']);
        exit;
    }

    public function send_driver_message()
    {
        $title = 'test title';
        $content = trim($this->input->get_post('content', TRUE));

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (empty($content)) {
            $this->app_error_func(997, 'content 参数错误');
            exit;
        }

        $push_st = push_xingeapp($this->data['driver_data']['driver_mobile'], 2, $content);

        $this->common_model->trans_begin();

        $time = time();

        // 记录日志
        $data = array(
            'driver_id' => $this->data['driver_id'],
            'push_desc' => $push_st,
            'cretime' => $time,
        );
        $this->common_model->insert('xingeapp_driver_log', $data);

        // 司机日志
        $data = array(
            'driver_id' => $this->data['driver_id'],
            'title' => 'public_driver_message',
            'content' => $title."-".$content,
            'cretime' => $time,
        );
        $this->common_model->insert('driver_message', $data);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            $this->app_error_func(999, '操作失败');
            exit;
        }
        $this->common_model->trans_commit();

        echo json_en($this->data['error']);
        exit;
    }
}