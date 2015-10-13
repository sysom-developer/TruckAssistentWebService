<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipper extends Public_Android_Controller {

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
            'body' => array(
                'data_list' => array(),
            ),
        );
    }

    public function index()
    {

    }

    public function get_all_data_list()
    {
        $where = array(
            'is_select' => 1,
        );
        $data_list = $this->shipper_company_service->get_shipper_company_data_list($where);
        if ($data_list) {
            foreach ($data_list as $key => &$value) {
                // 货主信息
                $where = array(
                    'company_id' => $value['id'],
                );
                $shipper_data = $this->shipper_service->get_shipper_data($where, 1, 0);
                $value['shipper_id'] = $shipper_data['shipper_id'];
            }
        }
        $this->data['error']['body']['data_list'] = $data_list;

        echo json_en($this->data['error']);
        exit;
    }

    public function get_data_list()
    {
        $current_province_name = $this->input->get_post('current_province_name', TRUE);

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
        );
        $shipper_driver_data = $this->shipper_driver_service->get_shipper_driver_data_list($where);
        $shipper_company_ids = array();
        if ($shipper_driver_data) {
            foreach ($shipper_driver_data as $key => $value) {
                $shipper_company_ids[] = $value['shipper_company_id'];
            }
        }

        if (empty($shipper_company_ids)) {
            echo json_en($this->data['error']);
            exit;
        }

        if (empty($current_province_name)) {
            $where = array(
                'id' => $shipper_company_ids,
            );
            $shipper_company_data_list = $this->shipper_company_service->get_shipper_company_data_list($where);
            if ($shipper_company_data_list) {
                foreach ($shipper_company_data_list as $key => $value) {
                    $where = array(
                        'company_id' => $value['id'],
                    );
                    $shipper_data = $this->shipper_service->get_shipper_data($where, 1, 0);
                    if ($shipper_data && !(array_key_exists($value['id'], $this->data['error']['body']['data_list']))) {
                        $value['shipper_id'] = $shipper_data['shipper_id'];
                        $this->data['error']['body']['data_list'][$value['id']] = $value;
                    }
                }
            }
        } else {
            $where = array(
                'shipper_company_id' => $shipper_company_ids,
            );
            $shipper_route_data_list = $this->shipper_route_service->get_shipper_route_data_list($where);
            if ($shipper_route_data_list) {
                foreach ($shipper_route_data_list as $key => $value) {
                    $route_data = $this->route_service->get_route_by_id($value['route_id']);
                    $region_data = $this->region_service->get_region_by_id($route_data['start_province_id']);
                    if (stripos($current_province_name, $region_data['region_name']) !== FALSE) {
                        // 货运公司信息
                        $shipper_company_data = $this->shipper_company_service->get_shipper_company_by_id($value['shipper_company_id']);

                        // 货主信息
                        $where = array(
                            'company_id' => $value['shipper_company_id'],
                        );
                        $shipper_data = $this->shipper_service->get_shipper_data($where, 1, 0);
                        if ($shipper_data && !(array_key_exists($shipper_company_data['id'], $this->data['error']['body']['data_list']))) {
                            $shipper_company_data['shipper_id'] = $shipper_data['shipper_id'];
                            $this->data['error']['body']['data_list'][$shipper_company_data['id']] = $shipper_company_data;
                        }
                    }
                }
            }
        }

        if (!empty($this->data['error']['body']['data_list'])) {
            sort($this->data['error']['body']['data_list']);
        }

        echo json_en($this->data['error']);
        exit;
    }
}