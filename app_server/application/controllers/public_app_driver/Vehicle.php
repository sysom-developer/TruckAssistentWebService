<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends Public_Android_Controller {

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
     * 根据司机id获取车辆
     */
    public function get_vehicle_by_driver_id()
    {
        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        // 车辆信息
        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        $vehicle_data = $this->vehicle_service->get_vehicle_data($where);
        if (empty($vehicle_data)) {
            $this->app_error_func(997, '该司机无车辆');
            exit;
        }

        // 车辆类型
        // $vehicle_type_data = $this->vehicle_service->get_vehicle_type_by_id($vehicle_data['vehicle_type']);

        // 车辆吨位
        // $vehicle_load_data = $this->vehicle_service->get_vehicle_load_by_id($vehicle_data['vehicle_load']);

        // 车辆长度
        // $vehicle_length_data = $this->vehicle_service->get_vehicle_length_by_id($vehicle_data['vehicle_length']);

        // 驾驶证
        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['driver_data']['driver_license_icon']);
        $driver_license_icon = $attachment_data['http_file'];

        // 行驶证
        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['driver_data']['driver_vehicle_license_icon']);
        $driver_vehicle_license_icon = $attachment_data['http_file'];

        $this->data['error']['body']['vehicle_data'] = array(
            'vehicle_id' => $vehicle_data['vehicle_id'],
            'vehicle_card_num' => !empty($vehicle_data['vehicle_card_num']) ? $vehicle_data['vehicle_card_num'] : '',
            'vehicle_type' => !empty($vehicle_data['vehicle_type']) ? $vehicle_data['vehicle_type'] : '',
            'vehicle_load' => !empty($vehicle_data['vehicle_load']) ? $vehicle_data['vehicle_load'] : '',
            'vehicle_length' => !empty($vehicle_data['vehicle_length']) ? $vehicle_data['vehicle_length'] : '',
            'driver_license_icon' => !empty($driver_license_icon) ? $driver_license_icon : '',
            'driver_vehicle_license_icon' => !empty($driver_vehicle_license_icon) ? $driver_vehicle_license_icon : '',
        );

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 车辆类型
     */
    public function get_vehicle_type()
    {
        $data = $this->config->item('type', 'vehicle');;
        $this->data['error']['body']['data_list'] = array_values($data);

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 车辆载重
     */
    public function get_vehicle_load()
    {
        $data = $this->config->item('load', 'vehicle');
        $this->data['error']['body']['data_list'] = array_values($data);

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 车辆长度
     */
    public function get_vehicle_length()
    {
        $data = $this->config->item('length', 'vehicle');
        $this->data['error']['body']['data_list'] =  array_values($data);

        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 车辆后桥速比
     */
    public function get_vehicle_rear_axle_ratio()
    {
        $data = $this->config->item('rear_axle_ratio', 'vehicle');
        $this->data['error']['body']['data_list'] =  array_values($data);

        echo json_en($this->data['error']);
        exit;
    }

    public function index()
    {
    }

    /**
     * 车辆品牌
     */
    public function get_vehicle_brand()
    {
        $data = $this->config->item('brand', 'vehicle');
        $this->data['error']['body']['data_list'] =  array_values($data);

        echo json_en($this->data['error']);
        exit;
    }
    /**
     * 车辆型号
     */
    public function get_vehicle_model()
    {
        $data = $this->config->item('model', 'vehicle');
        $this->data['error']['body']['data_list'] =  array_values($data);

        echo json_en($this->data['error']);
        exit;
    }
    /**
     * 根据车辆品牌获取发动机品牌
     */
    public function get_engine_brand_displacement()
    {
        $engine_brand = $this->config->item('engine_brand', 'vehicle');
        $engine_displacement = $this->config->item('engine_displacement', 'vehicle');
        $data = [
            'engine_brand' => $engine_brand,
            'engine_displacement' => $engine_displacement
        ];
        $this->data['error']['body']['data_list'] =  $data;

        echo json_en($this->data['error']);
        exit;
    }
}