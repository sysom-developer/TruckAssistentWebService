<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_orders_count($where = array()) {
        if ($this->appfolder == 'web_shipper') $where['shipper_id'] = $this->shipper_info['shipper_ids'];
        $where['order_status'] = 1;
        
        $count = $this->common_model->get_count('orders', $where);

        return $count;
    }

    public function get_orders_data($where = array(), $limit = '', $offset = '', $order = 'order_id', $by = 'ASC') {
        if ($this->appfolder == 'web_shipper') $where['shipper_id'] = $this->shipper_info['shipper_ids'];
        $where['order_status'] = 1;

        $data = $this->common_model->get_data('orders', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_orders_by_id($id) {
        $where = array(
            'order_id' => $id,
        );
        if ($this->appfolder == 'web_shipper') $where['shipper_id'] = $this->shipper_info['shipper_ids'];
        $where['order_status'] = 1;
        
        $data = $this->common_model->get_data('orders', $where)->row_array();

        return $data;
    }

    public function get_orders_data_list($where = array(), $limit = '', $offset = 0, $order = 'order_id', $by = 'ASC') {
        if ($this->appfolder == 'web_shipper') $where['shipper_id'] = $this->shipper_info['shipper_ids'];
        $where['order_status'] = 1;

        $data = $this->common_model->get_data('orders', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

    public function get_draft_orders_data_list()
    {
        $where = array(
            'order_status' => 1,
            'order_type' => 1,
            // 'is_view_draft' => 1,
        );
        if ($this->appfolder == 'web_shipper') $where['shipper_id'] = $this->shipper_info['shipper_ids'];

        $data_list = $this->get_orders_data_list($where);

        return $data_list;
    }

    public function update_draft_orders_status()
    {
        $data = array(
            'is_view_draft' =>2,
        );
        $where = array(
            'order_status' => 1,
            'order_type' => 1,
            'is_view_draft' => 1,
        );
        if ($this->appfolder == 'web_shipper') $where['shipper_id'] = $this->shipper_info['shipper_ids'];
        
        $affected_rows = $this->common_model->update('orders', $data, $where);

        return $affected_rows;
    }

    public function get_track_by_id($order_id)
    {
        $track_data = array();

        if (!(is_numeric($order_id) && $order_id > 0)) {
            return $track_data;
        }

        $where = array(
            'order_id' => $order_id,
        );
        $data_list = $this->order_log_service->get_order_log_data_list($where);
        if ($data_list) {
            $driver_id = $data_list[0]['driver_id'];

            $order_type_3_time = 0;
            $order_type_4_time = 0;
            $order_type_5_time = 0;
            foreach ($data_list as $key => $value) {
                if ($value['order_type'] == 3) {
                    $order_type_3_time = strtotime($value['create_time']);
                }
                if ($value['order_type'] == 4) {
                    $order_type_4_time = strtotime($value['create_time']);
                }
                if ($value['order_type'] == 5) {
                    $order_type_5_time = strtotime($value['create_time']);
                }
            }

            $where = array(
                'driver_id' => $driver_id,
                'UNIX_TIMESTAMP(create_time) >=' => $order_type_3_time,
                'UNIX_TIMESTAMP(create_time) <=' => $order_type_5_time,
            );
            $track_data_list = $this->tracking_service->get_tracking_data_list($where);

            $i = 0;
            $j = 0;
            foreach ($data_list as $key => $value) {
                if ($value['order_type'] == 3) {
                    $track_data[] = array(
                        'track_desc' => '已经接单',
                        'track_time' => tran_time(strtotime($value['create_time'])),
                        'time' => strtotime($value['create_time']),
                    );

                    if ($track_data_list) {
                        $first_track_time = strtotime($track_data_list[0]['create_time']);
                        foreach ($track_data_list as $t_key => $t_value) {
                            $t_time = strtotime($t_value['create_time']);

                            if ($i == 0) {
                                $interval_time = $first_track_time + 3600 * 4;
                            }

                            if ($t_time >= $interval_time) {
                                $interval_time = $t_time + 3600 * 4;

                                $track_data[] = array(
                                    'track_desc' => $t_value['province_name'].$t_value['city_name'],
                                    'track_time' => tran_time($t_time),
                                    'time' => $t_time,
                                );

                                $i++;
                            }
                        }
                    }
                }

                if ($value['order_type'] == 4) {
                    $track_data[] = array(
                        'track_desc' => '已经发车',
                        'track_time' => tran_time(strtotime($value['create_time'])),
                        'time' => strtotime($value['create_time']),
                    );

                    if ($track_data_list) {
                        $first_track_time = strtotime($track_data_list[0]['create_time']);
                        foreach ($track_data_list as $t_key => $t_value) {
                            $t_time = strtotime($t_value['create_time']);

                            if ($j == 0) {
                                $interval_time = $first_track_time + 3600 * 4;
                            }

                            if ($t_time >= $interval_time) {
                                $interval_time = $t_time + 3600 * 4;

                                $track_data[] = array(
                                    'track_desc' => $t_value['province_name'].$t_value['city_name'],
                                    'track_time' => tran_time($t_time),
                                    'time' => $t_time,
                                );

                                $j++;
                            }
                        }
                    }

                    // 检查是否有异常数据
                    $where = array(
                        'order_id' => $order_id,
                    );
                    $driver_anomaly_data_list = $this->driver_anomaly_service->get_driver_anomaly_data_list($where);
                    $driver_anomaly = array();
                    if ($driver_anomaly_data_list) {
                        foreach ($driver_anomaly_data_list as $value2) {
                            $where = array(
                                'driver_anomaly_id' => $value2['id'],
                            );
                            $driver_anomaly_attachment_data_list = $this->driver_anomaly_service->get_driver_anomaly_attachment_data_list($where);

                            $driver_anomaly_img_list = array();
                            if ($driver_anomaly_attachment_data_list) {
                                foreach ($driver_anomaly_attachment_data_list as $value3) {
                                    $attachment_data = $this->attachment_service->get_attachment_by_id($value3['attachment_id']);
                                    $driver_anomaly_img_list[] = $attachment_data['http_file'];
                                }
                            }

                            $track_data[] = array(
                                'track_desc' => $value2['exce_desc'],
                                'province_name' => $value2['province_name'],
                                'city_name' => $value2['city_name'],
                                'speedInKPH' => $value2['speedInKPH'],
                                'heading' => $value2['heading'],
                                'track_time' => tran_time($value2['cretime']),
                                'driver_anomaly_img_list' => $driver_anomaly_img_list,
                                'time' => $value2['cretime'],
                            );
                        }
                    }
                }

                if ($value['order_type'] == 5) {
                    $track_data[] = array(
                        'track_desc' => '运单完成',
                        'track_time' => tran_time(strtotime($value['create_time'])),
                        'time' => strtotime($value['create_time']),
                    );
                }
            }
        }

        $track_data = multi_array_sort($track_data, 'time', SORT_DESC);

        return $track_data;
    }

}