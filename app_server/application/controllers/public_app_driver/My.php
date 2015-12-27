<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My extends Public_Android_Controller {

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

    /**
     * 根据司机id获取自己资料
     */
    public function index()
    {
        $driver_id = trim($this->input->get_post('type', true));;


        $data = [
            'driver_id' => 90,
            'name' => 'llldd',
            'driver_head_icon' => 'xxx',
            'login_name' => '13486750875'
        ];

        $this->data['error']['body']['data'] = $data;

        echo json_en($this->data['error']);
        exit;
    }

    public function update_head_icon(){
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(1899, 'driver_id 参数错误');
            exit;
        }
        $data = [];
        $driver_head_icon_attachment_id = '';
        $driver_head_icon_upload_data = upload_img_file('driver_head_icon', 'driver_head_icon_img');

        if ($driver_head_icon_upload_data['status'] != -1) {
            $filepath = substr($driver_head_icon_upload_data['data']['file_path'], stripos($driver_head_icon_upload_data['data']['file_path'], "data_tmp"));
            $attachment_data = array(
                'filetype' => $driver_head_icon_upload_data['data']['file_type'],
                'filename' => $driver_head_icon_upload_data['data']['file_name'],
                'filesize' => $driver_head_icon_upload_data['data']['file_size'],
                'filepath' => $filepath,
            );
            $driver_head_icon_img_attachment_id = $this->common_model->insert('attachment_tmp', $attachment_data);
            $driver_head_icon_attachment_id = move_upload_file($driver_head_icon_img_attachment_id);
            $data['driver_head_icon'] = $driver_head_icon_attachment_id;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        if(!empty($data)){
            $this->common_model->update('driver', $data, $where);

        }
        echo json_en($this->data['error']);
        exit;
    }

    public function update_nick_name(){
        echo json_en($this->data['error']);
        exit;
    }

    public function update_pwd(){
        echo json_en($this->data['error']);
        exit;
    }

}
