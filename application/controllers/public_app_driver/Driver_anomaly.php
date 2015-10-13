<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_anomaly extends Public_Android_Controller {

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
        $time = time();

        $order_id = $this->input->get_post('order_id', TRUE);
        $exce_desc = trim($this->input->get_post('exce_desc', TRUE));
        $latitude = $this->input->get_post('latitude', TRUE);
        $longitude = $this->input->get_post('longitude', TRUE);
        $province_name = $this->input->get_post('province_name', TRUE);
        $city_name = $this->input->get_post('city_name', TRUE);
        $device = $this->input->get_post('device', TRUE);
        $speedInKPH = $this->input->get_post('speedInKPH', TRUE);
        $heading = $this->input->get_post('heading', TRUE);

        if (!(is_numeric($order_id) && $order_id > 0)) {
            $this->app_error_func(998, 'order_id 参数错误');
            exit;
        }

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(997, 'driver_id 参数错误');
            exit;
        }

        $where = array(
            'order_id' => $order_id,
            'driver_id' => $this->data['driver_id'],
        );
        $order_data = $this->orders_service->get_orders_data($where, 1, 0, 'order_id', 'DESC');
        if (empty($order_data)) {
            $this->app_error_func(888, '运单不存在');
            exit;
        }

        $data = array(
            'company_id' => $this->data['shipper_driver_data']['shipper_company_id'],
            'order_id' => $order_id,
            'driver_id' => $this->data['driver_id'],
            'exce_desc' => $exce_desc,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'province_name' => $province_name,
            'city_name' => $city_name,
            'device' => $device,
            'speedInKPH' => $speedInKPH,
            'heading' => $heading,
            'cretime' => $time,
        );
        $driver_anomaly_id = $this->common_model->insert('driver_anomaly', $data);
        if (empty($driver_anomaly_id)) {
            $this->app_error_func(887, '数据写入失败');
            exit;
        }

        for ($i=1; $i<=6; $i++) {
            $file_id = 'anomaly_file_'.$i;
            $upload_data = upload_img_file($file_id, 'driver_anomaly_img');

            if ($upload_data['status'] != -1) {
                $filepath = substr($upload_data['data']['file_path'], stripos($upload_data['data']['file_path'], "data_tmp"));
                $data = array(
                    'filetype' => $upload_data['data']['file_type'],
                    'filename' => $upload_data['data']['file_name'],
                    'filesize' => $upload_data['data']['file_size'],
                    'filepath' => $filepath,
                );
                $attachment_tmp_id = $this->common_model->insert('attachment_tmp', $data);
                if (empty($attachment_tmp_id)) {
                    $this->app_error_func(886, '附件临时表写入失败');
                    exit;
                }

                $attachment_id = move_upload_file($attachment_tmp_id);
                if (empty($attachment_id)) {
                    $this->app_error_func(885, '附件表写入失败');
                    exit;
                }

                $data = array(
                    'driver_anomaly_id' => $driver_anomaly_id,
                    'order_id' => $order_id,
                    'driver_id' => $this->data['driver_id'],
                    'attachment_id' => $attachment_id,
                );
                $this->common_model->insert('relation_driver_anomaly_attachment', $data);
            }
        }

        // 增加积分
        $rtn = $this->driver_service->update_driver_score($this->data['driver_id'], 3);
        if ($rtn === FALSE) {
            $this->app_error_func(666, '积分增加失败');
            exit;
        }
        $this->data['error']['body'] = $rtn;

        echo json_en($this->data['error']);
        exit;
    }
}