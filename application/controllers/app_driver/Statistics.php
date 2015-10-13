<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends Android_Controller {

    public function index()
    {
        $error = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => '',
                ),
            ),
            'body' => array(
                'rank' => 0,    // 排名
                'current_month' => date('Y年n月份'),
                'month_freight' => 0,  // 本月收益
                'order_count_freight' => 0, // 运单总收益
                'order_count' => 0, // 运单总数量
                'shipper_comment' => 0, // 货主评价
            ),
        );

        $driver_id = $this->input->get_post('driver_id', TRUE);

        if (!(is_numeric($driver_id) && $driver_id > 0)) {
            $error['application']['head']['code'] = 998;
            $error['application']['head']['description'] = 'driver_id 参数错误';
            echo json_en($error);
            exit;
        }

        // 司机评价
        $error['body']['shipper_comment'] = $this->comment_service->get_avg_driver_comment_by_id($driver_id);

        $time = time();

        $where = array(
            'order_type' => array(4, 5),
        );
        $order_data_list = $this->orders_service->get_orders_data_list($where, '','', 'good_start_time', 'ASC');
        if ($order_data_list) {
            $driver_data = array();

            $first_date = date('Y-m-01');
            $first_day = strtotime($first_date);
            $last_day = strtotime(date('Y-m-d 23:59:59', strtotime("$first_date +1 month -1 day")));

            $tmp_year_count = $tmp_year_freight_count = array();
            $i = 1;
            foreach ($order_data_list as $value) {
                if ($value['good_start_time'] <= 0) {
                    continue;
                }

                if ($value['good_start_time'] >= $first_day && $value['good_start_time'] <= $last_day) {
                    if (isset($driver_data[$value['driver_id']])) {
                        $driver_data[$value['driver_id']] += $value['good_freight'];
                    } else {
                        $driver_data[$value['driver_id']] = $value['good_freight'];
                    }
                }

                if ($value['driver_id'] != $driver_id) {
                    continue;
                }

                $year_month = date('Y-m', $value['good_start_time']);

                $error['body']['order_count_freight'] += $value['good_freight'];
                $error['body']['order_count'] += 1;

                if (isset($tmp_year_count[$year_month])) {
                    $tmp_year_count[$year_month] += 1;
                } else {
                    $tmp_year_count[$year_month] = 1;
                }

                if (isset($tmp_year_freight_count[$year_month])) {
                    $tmp_year_freight_count[$year_month] += $value['good_freight'];
                } else {
                    $tmp_year_freight_count[$year_month] = $value['good_freight'];
                }
            }

            $year_count = array();
            foreach ($tmp_year_count as $month => $count) {
                $year_count[] = array(
                    'month' => $month,
                    'count' => $count,
                );
            }

            $year_freight_count = array();
            foreach ($tmp_year_freight_count as $month => $good_freight_count) {
                $year_freight_count[] = array(
                    'month' => $month,
                    'count' => $good_freight_count,
                );
            }

            $tmp_year_count = array();
            foreach ($year_count as $key => $value) {
                foreach ($year_freight_count as $k => $v) {
                    if ($value['month'] == $v['month']) {
                        $tmp_year_count[] = array(
                            'month' => $v['month'],
                            'count' => $value['count'],
                            'freight_count' => $v['count'],
                        );
                    }
                }
            }

            if ($tmp_year_count) {
                $tmp_year_count = multi_array_sort($tmp_year_count, 'month');
            }

            $error['body']['year_count'] = $tmp_year_count;

            $error['body']['month_freight'] = isset($driver_data[$driver_id]) ? $driver_data[$driver_id] : 0;

            // 计算排名
            if ($driver_data) {
                $tmp_driver_data = array();
                foreach ($driver_data as $d_id => $good_freight) {
                    $tmp_driver_data[] = array(
                        'driver_id' => $d_id,
                        'good_freight' => $good_freight,
                    );
                }

                $driver_data = $tmp_driver_data;

                foreach ($driver_data as $key => $value) {
                    if ($value['driver_id'] == $driver_id && $error['body']['month_freight'] >= $value['good_freight']) {
                        $error['body']['rank'] = $key + 1;
                        break;
                    }
                }
            }
        }

        echo json_en($error);
        exit;
    }
}