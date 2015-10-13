<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends Public_Android_Controller {

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

    public function add_data()
    {
        $driver_id = trim($this->input->get_post('driver_id', TRUE));
        $vehicle_id = trim($this->input->get_post('vehicle_id', TRUE));
        $latitude = trim($this->input->get_post('latitude'));
        $longitude = trim($this->input->get_post('longitude', TRUE));
        $province_name = trim($this->input->get_post('province_name', TRUE));
        $city_name = trim($this->input->get_post('city_name', TRUE));
        $device = trim($this->input->get_post('device', TRUE));
        $speedInKPH = trim($this->input->get_post('speedInKPH', TRUE));
        $heading = trim($this->input->get_post('heading', TRUE));
        $provider = trim($this->input->get_post('provider', TRUE));

        $this->common_model->trans_begin();

        $time = time();

        // 写入tracking信息
        $data = array(
            'driver_id' => $driver_id,
            'vehicle_id' => $vehicle_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'province_name' => $province_name,
            'city_name' => $city_name,
            'device' => $device,
            'speedInKPH' => $speedInKPH,
            'timestamp' => date('Y-m-d H:i:s', $time),
            'heading' => $heading,
            'provider' => $provider,
            'timeInterval' => 0,
            'distanceInterval' => 0,
            'create_time' => date('Y-m-d H:i:s', $time),
        );
        $insert_id = $this->common_model->insert('tracking', $data);
        if ($insert_id == 0) {
            $this->common_model->trans_rollback();

            $this->app_error_func(998, 'tracking 信息写入失败');
            exit;
        }

        // 写入 vehicle_location 表信息
        $where = array(
            'driver_id' => $driver_id,
            'vehicle_id' => $vehicle_id,
        );
        $vehicle_location_data = $this->vehicle_location_service->get_vehicle_location_data($where);
        $data = array(
            'driver_id' => $driver_id,
            'vehicle_id' => $vehicle_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'province_name' => $province_name,
            'city_name' => $city_name,
            'device' => $device,
            'speedInKPH' => $speedInKPH,
            'timestamp' => date('Y-m-d H:i:s', $time),
            'heading' => $heading,
            'provider' => $provider,
            'timeInterval' => 0,
            'distanceInterval' => 0,
            'update_time' => date('Y-m-d H:i:s', $time),
        );
        if (empty($vehicle_location_data)) {    // insert
            $this->common_model->insert('vehicle_location', $data);
        } else {    // update
            $where = array(
                'driver_id' => $driver_id,
                'vehicle_id' => $vehicle_id,
            );
            $this->common_model->update('vehicle_location', $data, $where);
        }

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