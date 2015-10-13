<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_vehicle_data($where) {
        $where['vehicle_status'] = 1;
        $data = $this->common_model->get_data('vehicle', $where)->row_array();

        return $data;
    }

    public function get_vehicle_by_id($vehicle_id) {
        $where = array(
            'vehicle_id' => $vehicle_id,
            'vehicle_status' => 1,
        );
        $data = $this->common_model->get_data('vehicle', $where)->row_array();

        return $data;
    }

    public function get_vehicle_data_list($where = array(), $limit = '', $offset = 0, $order = 'vehicle_id', $by = 'ASC') {
        $where['vehicle_status'] = 1;
        $data = $this->common_model->get_data('vehicle', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

    public function get_current_shipper_driver_vehicle_options($id = 0, $where = array()) {
        $shipper_driver_data_list = $this->shipper_driver_service->get_shipper_driver_data_list($where);

        $driver_ids = array();
        if ($shipper_driver_data_list) {
            foreach ($shipper_driver_data_list as $value) {
                $driver_ids[$value['driver_id']] = $value['driver_id'];
            }
        }

        $options = '<option value="0">请选择</option>';
        if (!empty($driver_ids)) {
            $options = '';
            
            $where = array(
                'driver_id' => $driver_ids,
            );
            $vehicle_data_list = $this->get_vehicle_data_list($where, 'vehicle_id', 'DESC');

            
            if ($vehicle_data_list) {
                foreach ($vehicle_data_list as $data) {
                    $selected = '';
                    if ($id == $data['vehicle_id']) {
                        $selected = 'selected';
                    }

                    $driver_data = $this->driver_service->get_driver_by_id($data['driver_id']);

                    $options .= "<option value=" . $data['vehicle_id'] . " " . $selected . ">（" . $driver_data['driver_name'] . "）" . $data['vehicle_card_num'] . "</option>";
                }
            }
        }

        return $options;
    }

    public function get_vehicle_type_by_id($type_id) {
        $where = array(
            'type_id' => $type_id,
            'type_status' => 1,
        );
        $data = $this->common_model->get_data('vehicle_type', $where)->row_array();

        return $data;
    }

    public function get_vehicle_type_data_list($order = 'type_id', $by = 'ASC') {
        $where = array(
            'type_status' => 1,
        );
        $data = $this->common_model->get_data('vehicle_type', $where, '', '', $order, $by)->result_array();

        return $data;
    }

    public function get_vehicle_type_options($type_id = 0) {
        $data_list = $this->get_vehicle_type_data_list('type_id', 'DESC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($type_id == $data['type_id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['type_id'] . " " . $selected . ">" . $data['type_name'] . "</option>";
            }
        }

        return $options;
    }

    public function get_vehicle_length_by_id($l_id) {
        $where = array(
            'l_id' => $l_id,
            'status' => 1,
        );
        $data = $this->common_model->get_data('vehicle_length', $where)->row_array();

        return $data;
    }

    public function get_vehicle_length_data_list($order = 'l_id', $by = 'ASC') {
        $where = array(
            'status' => 1,
        );
        $data = $this->common_model->get_data('vehicle_length', $where, '', '', $order, $by)->result_array();

        return $data;
    }

    public function get_vehicle_length_options($l_id = 0) {
        $data_list = $this->get_vehicle_length_data_list('l_id', 'DESC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($l_id == $data['l_id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['l_id'] . " " . $selected . ">" . $data['length'] . "</option>";
            }
        }

        return $options;
    }

    public function get_vehicle_load_by_id($load_id) {
        $where = array(
            'load_id' => $load_id,
            'status' => 1,
        );
        $data = $this->common_model->get_data('vehicle_load', $where)->row_array();

        return $data;
    }

    public function get_vehicle_load_data_list($order = 'load_id', $by = 'ASC') {
        $where = array(
            'status' => 1,
        );
        $data = $this->common_model->get_data('vehicle_load', $where, '', '', $order, $by)->result_array();

        return $data;
    }

    public function get_vehicle_load_options($load_id = 0) {
        $data_list = $this->get_vehicle_load_data_list('load_id', 'DESC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($load_id == $data['load_id']) {
                    $selected = 'selected';
                }

                $options .= "<option value=" . $data['load_id'] . " " . $selected . ">" . $data['load'] . "</option>";
            }
        }

        return $options;
    }
    
}