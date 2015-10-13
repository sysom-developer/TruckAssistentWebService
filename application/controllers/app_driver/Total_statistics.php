<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Total_statistics extends Android_Controller {

    public function index()
    {
        $error = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => '',
                ),
            ),
            'body' => array(),
        );

        $time = time();

        $driver_id = $this->input->get_post('driver_id', TRUE);
        // 2015-06
        $date = $this->input->get_post('date', TRUE);
        $unixtime = strtotime($date);

        if (!(is_numeric($driver_id) && $driver_id > 0)) {
            $error['application']['head']['code'] = 998;
            $error['application']['head']['description'] = 'driver_id 参数错误';
            echo json_en($error);
            exit;
        }

        if ($unixtime == 0) {
            $unixtime = $time;
        }

        $show_num = 10; // 显示记录数

        $first_date = date('Y-m-01', $unixtime);
        $first_day = strtotime($first_date);
        $last_day = strtotime(date('Y-m-d 23:59:59', strtotime("$first_date +1 month -1 day")));

        $where = array(
            'order_type' => array(4, 5),
            'good_start_time >=' => $first_day,
            'good_start_time <=' => $last_day,
        );
        $order_data_list = $this->orders_service->get_orders_data_list($where, '','', 'good_start_time', 'ASC');

        if ($order_data_list) {
            $driver_data = array();
            $count_data = array();
            
            foreach ($order_data_list as $value) {
                $shipper_data = $this->shipper_service->get_shipper_by_id($value['shipper_id']);

                // 过滤 上海麦速物联网科技有限公司
                if ($value['good_start_time'] <= 0 || $shipper_data['company_id'] == 3) {
                    continue;
                }

                if (isset($driver_data[$value['driver_id']])) {
                    $driver_data[$value['driver_id']] += $value['good_freight'];
                    $count_data[$value['driver_id']] += 1;
                } else {
                    $driver_data[$value['driver_id']] = $value['good_freight'];
                    $count_data[$value['driver_id']] = 1;
                }
            }

            $tmp_data_list = array();
            $i = 1;
            foreach ($driver_data as $d_id => $value) {
                foreach ($count_data as $k2 => $v2) {
                    if ($k2 == $d_id) {
                        // 司机信息
                        $driver_data = $this->driver_service->get_driver_by_id($d_id);

                        $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_head_icon']);
                        $driver_avatar = $attachment_data['http_file'];

                        // 司机评价
                        $driver_comment = $this->comment_service->get_avg_driver_comment_by_id($d_id);

                        $tmp_data_list[$i] = array(
                            'driver_id' => $d_id,
                            'driver_avatar' => $driver_avatar,
                            'driver_name' => $driver_data['driver_name'],
                            'count' => $v2,
                            'good_freight_count' => $value,
                            'is_self' => 0,
                            'shipper_comment' => $driver_comment,
                        );

                        if ($d_id == $driver_id) {
                            $tmp_data_list[$i]['is_self'] = 1;
                        }

                        $i++;
                    }
                }
            }

            $tmp_data_list = multi_array_sort($tmp_data_list, 'good_freight_count', SORT_DESC);

            $data_list = array();
            
            $i = 1;
            foreach ($tmp_data_list as $value) {
                $value['rank'] = $i;
                $data_list[] = $value;

                $i++;
            }

            $self_rank = FALSE;
            $self_data = array();
            foreach ($data_list as $rank => $value) {
                if ($value['driver_id'] == $driver_id) {
                    $self_rank = $rank;
                    $self_data = $value;
                    break;
                }
            }

            if (count($data_list) > $show_num) {
                if ($self_rank === FALSE) {
                    $data_list = array_slice($data_list, 0, $show_num - 1);

                    if (empty($self_data)) {
                        // 司机信息
                        $driver_data = $this->driver_service->get_driver_by_id($driver_id);

                        $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_head_icon']);
                        $driver_avatar = $attachment_data['http_file'];

                        // 司机评价
                        $driver_comment = $this->comment_service->get_avg_driver_comment_by_id($driver_id);

                        $driver_data_list = $this->driver_service->get_driver_data_list(array());

                        $self_data = array(
                            'driver_id' => $driver_id,
                            'driver_avatar' => $driver_avatar,
                            'driver_name' => $driver_data['driver_name'],
                            'count' => 0,
                            'good_freight_count' => 0,
                            'is_self' => 0,
                            'shipper_comment' => $driver_comment,
                            'rank' => count($driver_data_list) - 1,
                        );
                    }

                    array_push($data_list, $self_data);
                } else {
                    $data_list = array_slice($data_list, 0, $show_num);
                    $data_list[$self_rank] = $self_data;
                }
            }

            // echo '<pre>';
            // print_r($data_list);
            // exit;

            $error['body']['data_list'] = $data_list;
        }

        echo json_en($error);
        exit;
    }
}