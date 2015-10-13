<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipper_driver_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_shipper_driver_data($where) {
        if ($this->appfolder == 'web_shipper') $where['shipper_company_id'] = $this->shipper_info['company_id'];

        $data = $this->common_model->get_data('shipper_driver', $where)->row_array();

        return $data;
    }

    public function get_shipper_driver_by_id($id) {
        $where = array(
            'id' => $id,
        );
        if ($this->appfolder == 'web_shipper') $where['shipper_company_id'] = $this->shipper_info['company_id'];

        $data = $this->common_model->get_data('shipper_driver', $where)->row_array();

        return $data;
    }

    public function get_shipper_driver_data_list($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        if ($this->appfolder == 'web_shipper') $where['shipper_company_id'] = $this->shipper_info['company_id'];

        $data_list = $this->common_model->get_data('shipper_driver', $where, $limit, $offset, $order, $by)->result_array();

        return $data_list;
    }

    public function get_shipper_driver_options($id = 0, $where = array()) {
        if ($this->appfolder == 'web_shipper') $where['shipper_company_id'] = $this->shipper_info['company_id'];

        $data_list = $this->get_shipper_driver_data_list($where, '', '', 'driver_id', 'DESC');
        $options = '';
        if ($data_list) {
            foreach ($data_list as $data) {
                $selected = '';
                if ($id == $data['id']) {
                    $selected = 'selected';
                }

                $driver_data = $this->driver_service->get_driver_by_id($data['driver_id']);

                $options .= "<option value=" . $driver_data['driver_id'] . " " . $selected . ">" . $driver_data['driver_name'] . "</option>";
            }
        }

        return $options;
    }

    // 货运公司货车数
    public function get_shipper_driver_count($shipper_info)
    {
        $return = array(
            'count' => 0,
            'driver_ids' => array(),
            'vehicle_ids' => array(),
        );

        if ($shipper_info['shipper_driver_data_list']) {
            foreach ($shipper_info['shipper_driver_data_list'] as $value) {
                $return['driver_ids'][$value['driver_id']] = $value['driver_id'];

                $where = array(
                    'driver_id' => $value['driver_id'],
                );
                $vehicle_data = $this->vehicle_service->get_vehicle_data($where);

                $return['vehicle_ids'][$vehicle_data['vehicle_id']] = $vehicle_data['vehicle_id'];
            }

            if ($return['driver_ids']) {
                $where = array(
                    'driver_id' => $return['driver_ids'],
                );
                $data_list = $this->vehicle_service->get_vehicle_data_list($where);

                $return['count'] = count($data_list);
            }
        }
        
        return $return;
    }

    // 不可用车辆（ 在途 order_type 4 ） driver_id 集合
    public function get_carry_driver_ids($shipper_info, $order_type, $where = array())
    {
        $carry_driver_ids = array();

        if ($shipper_info['shipper_driver_data_list']) {
            $driver_ids = array();

            foreach ($shipper_info['shipper_driver_data_list'] as $value) {
                $driver_ids[$value['driver_id']] = $value['driver_id'];
            }

            if ($driver_ids) {
                $where['order_type'] = $order_type;
                $where['driver_id'] = $driver_ids;
                $order_data_list = $this->orders_service->get_orders_data_list($where);
                if ($order_data_list) {
                    foreach ($order_data_list as $key => $value) {
                        // 如果司机运的不是该货运公司的运单
                        if (!in_array($value['shipper_id'], $shipper_info['shipper_ids'])) {
                            unset($carry_driver_ids[$value['driver_id']]);
                            continue;
                        }

                        $carry_driver_ids[$value['driver_id']] = $value['driver_id'];
                    }
                }
            }
        }

        return $carry_driver_ids;
    }

    // 在途数 && 待运数
    public function get_order_driver_count($shipper_info, $order_type, $where = array())
    {
        $count = 0;

        $carry_driver_ids = $this->get_carry_driver_ids($shipper_info, $order_type, $where = array());
        $count = count($carry_driver_ids);
        
        return $count;
    }

    // 可用车辆（ 非在途 order_type 非 4 ） driver_id 集合
    public function get_sleep_driver_ids($shipper_info)
    {
        $sleep_driver_ids = array();

        if ($shipper_info['shipper_driver_data_list']) {
            $driver_ids = array();
            foreach ($shipper_info['shipper_driver_data_list'] as $value) {
                $driver_ids[$value['driver_id']] = $value['driver_id'];
            }

            if (!empty($driver_ids)) {
                $where = array(
                    'driver_id' => $driver_ids,
                );
                $data_list = $this->vehicle_service->get_vehicle_data_list($where);
                if ($data_list) {
                    foreach ($data_list as $vehicle_data) {
                        if (in_array($vehicle_data['driver_id'], $driver_ids)) {
                            $sleep_driver_ids[$vehicle_data['driver_id']] = $vehicle_data['driver_id'];
                        }
                    }
                }
            }
        }

        return $sleep_driver_ids;
    }

    // 未承运总数
    public function get_sleep_count_count($shipper_info)
    {
        $count = 0;

        $sleep_driver_ids = $this->get_sleep_driver_ids($shipper_info);
        $count = count($sleep_driver_ids);
        
        return $count;
    }

    // 未承运结果集
    public function get_sleep_count_data_list($shipper_info, $where = array(), $limit = '', $offset = 0, $order = 'vehicle_id', $by = 'ASC')
    {
        $data_list = array();

        if ($shipper_info['shipper_driver_data_list']) {
            $driver_ids = array();
            foreach ($shipper_info['shipper_driver_data_list'] as $value) {
                $where = array(
                    'driver_id' => $value['driver_id'],
                    'order_type' => array(4),
                );
                $order_data_list = $this->orders_service->get_orders_data_list($where);
                if (empty($order_data_list)) {
                    $driver_ids[$value['driver_id']] = $value['driver_id'];
                }
            }

            if (!empty($driver_ids)) {
                $where = array(
                    'driver_id' => $driver_ids,
                );
                $data_list = $this->vehicle_service->get_vehicle_data_list($where, $limit, $offset, $order, $by);
            }
        }
        
        return $data_list;
    }

    // 待调度总数
    public function get_dispatch_count_count($shipper_info)
    {
        $count = 0;

        if ($shipper_info['shipper_driver_data_list']) {
            $driver_ids = array();
            foreach ($shipper_info['shipper_driver_data_list'] as $value) {
                $where = array(
                    'driver_id' => $value['driver_id'],
                    'order_type' => array(4),
                );
                $order_data_list = $this->orders_service->get_orders_data_list($where);
                if ($order_data_list) { // 有无返程运单
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'order_type' => array(2),
                    );
                    $tmp_count = $this->orders_service->get_orders_count($where);
                    $count += $tmp_count > 0 ? 0 : 1;
                } else {    // 没有在途运单，有无待运运单
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'order_type' => array(3),
                    );
                    $tmp_count = $this->orders_service->get_orders_count($where);
                    $count += $tmp_count > 0 ? 0 : 1;
                }
            }
        }
        
        return $count;
    }

}