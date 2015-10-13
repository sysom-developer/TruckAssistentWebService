<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends Public_Android_Controller {

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

    public function get_province_data_list()
    {
        $where = array(
            'parent_id' => 1,
        );
        $data_list = $this->region_service->get_region_data_list($where);

        $this->data['error']['body']['data_list'] = $data_list;

        echo json_en($this->data['error']);
        exit;
    }

    public function get_city_data_list()
    {
        $province_id = intval($this->input->get_post('province_id', TRUE));

        if (empty($province_id)) {
            $this->app_error_func(998, 'province_id 参数错误');
            exit;
        }

        $where = array(
            'parent_id' => $province_id,
        );
        $data_list = $this->region_service->get_region_data_list($where);

        $this->data['error']['body']['data_list'] = $data_list;

        echo json_en($this->data['error']);
        exit;
    }

    public function get_history_region_data_list()
    {
        $select_type = $this->input->get_post('select_type', TRUE);

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (!in_array($select_type, array(1, 2))) {
            $this->app_error_func(997, 'select_type 参数错误');
            exit;
        }

        $where = array(
            'driver_id' => $this->data['driver_id'],
            'select_type' => $select_type,
        );
        $data_list = $this->driver_history_region_service->get_data_list($where, 6, 0, 'select_count', 'DESC');
        if ($data_list) {
            foreach ($data_list as $key => &$value) {
                $region_data = $this->region_service->get_region_by_id($value['city_id']);
                $value['region_name'] = $region_data['region_name'];
                $value['latitude'] = $region_data['latitude'];
                $value['longitude'] = $region_data['longitude'];
            }
        }
        $this->data['error']['body']['data_list'] = $data_list;

        echo json_en($this->data['error']);
        exit;
    }

    public function get_hot_region_data_list()
    {
        $where = array(
            'level' => 2,
            'is_hot' => 1,
        );
        $region_data_list = $this->region_service->get_region_data_list($where);
        if ($region_data_list) {
            foreach ($region_data_list as $key => &$value) {
                $value['city_id'] = $value['id'];
            }
        }

        $this->data['error']['body']['data_list'] = $region_data_list;

        echo json_en($this->data['error']);
        exit;
    }

    public function get_region_data_list()
    {
        $where = array(
            'level' => 2,
        );
        $region_data_list = $this->region_service->get_region_data_list($where);
        if ($region_data_list) {
            foreach ($region_data_list as $key => &$value) {
                $value['city_id'] = $value['id'];
            }
        }
        
        $this->data['error']['body']['data_list'] = $region_data_list;

        echo json_en($this->data['error']);
        exit;
    }

    public function update_region_position()
    {
        $where = array(
            'level' => 2,
        );
        $region_data_list = $this->region_service->get_region_data_list($where);
        if ($region_data_list) {
            foreach ($region_data_list as $key => $value) {
                $province_data = $this->region_service->get_region_by_id($value['parent_id']);
                $rtn = get_lat_lng_by_location($province_data['region_name'].$value['region_name']);

                $data = array(
                    'latitude' => $rtn['lat'],
                    'longitude' => $rtn['lng'],
                );
                $where = array(
                    'id' => $value['id'],
                );
                $this->common_model->update('region', $data, $where);
            }
        }
        $this->data['error']['body']['data_list'] = $region_data_list;

        echo json_en($this->data['error']);
        exit;
    }
}