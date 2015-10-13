<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Public_MY_Controller {

	public function index()
	{
        redirect(site_url($this->appfolder.'/vehicle/vehicle_list/?order_type=997'));

        $this->data['title'] = '首页';

        // 待调度车辆
        $this->data['dispatch_count'] = $this->shipper_driver_service->get_dispatch_count_count($this->shipper_info);

        // 在途运单
        $this->data['carry_count'] = $this->shipper_driver_service->get_order_driver_count($this->shipper_info, 4);

        // 未承运车辆
        $this->data['sleep_count'] = $this->shipper_driver_service->get_sleep_count_count($this->shipper_info);

        // 待接运单
        $where = array('order_type' => 1,);
        $this->data['wait_get_count'] = $this->orders_service->get_orders_count($where);

        // 待运运单
        $this->data['wait_count'] = $this->shipper_driver_service->get_order_driver_count($this->shipper_info, 3);

        // 待评价运单
        $where = array(
            'is_comment' => 2,
        );
        $this->data['wait_comment_count'] = $this->shipper_driver_service->get_order_driver_count($this->shipper_info, 5, $where);

        $this->data['stat_type'] = $this->input->get('stat_type', TRUE);
        $this->data['stat_type'] = $this->data['stat_type'] ? $this->data['stat_type'] : 'order_go_out';

        $this->data['echarts_type'] = $this->input->get('echarts_type', TRUE);
        $this->data['echarts_type'] = $this->data['echarts_type'] ? $this->data['echarts_type'] : 'day';

        $this->data['echarts_day_style'] = 'color: #333;';
        $this->data['echarts_month_style'] = 'color: #333;';
        if ($this->data['echarts_type'] == 'day') {
            $this->data['echarts_day_style'] = 'color: #fff;';
        } elseif ($this->data['echarts_type'] == 'month') {
            $this->data['echarts_month_style'] = 'color: #fff;';
        }

        $year_start = '2015-03-01';
        $year_end = date('Y-m-d');
        $this->data['get_week'] = get_week($year_start, $year_end);

        // 司机排行版
        $this->data['stat_driver_data_list'] = array();
        if (!empty($this->shipper_info['driver_ids'])) {
            $where = array(
                'driver_id' => $this->shipper_info['driver_ids'],
            );
            $driver_data_list = $this->driver_service->get_driver_data_list($where);
            if ($driver_data_list) {

                $first_day = date('Y-m-01 00:00:00');
                $last_day  = date('Y-m-d 23:59:59', strtotime("$first_day +1 month -1 day"));
                $first_time = strtotime($first_day);
                $last_time = strtotime($last_day);

                foreach ($driver_data_list as &$value) {
                    $attachment_data = $this->attachment_service->get_attachment_by_id($value['driver_head_icon']);
                    $value['driver_head_icon_http_file'] = $attachment_data['http_file'];

                    $where = array(
                        'driver_id' => $value['driver_id'],
                    );
                    $vehicle_data = $this->vehicle_service->get_vehicle_data($where);

                    $value['vehicle_data'] = $vehicle_data;

                    // 总发车数量
                    $where = array(
                        'driver_id' => $value['driver_id'],
                        'order_type' => array(4, 5),
                    );
                    $order_data_list = $this->orders_service->get_orders_data_list($where);
                    $value['count_go_to'] = 0;
                    $value['count_go_to'] = count($order_data_list);

                    $value['month_count_go_to'] = 0;
                    $value['count_good_freight'] = 0;
                    $value['month_count_good_freight'] = 0;
                    if ($order_data_list) {
                        foreach ($order_data_list as $value2) {
                            if ($value2['good_start_time'] >= $first_time && $value2['good_start_time'] <= $last_time) {
                                //本月发车
                                $value['month_count_go_to'] += 1;

                                // 本月收入
                                $value['month_count_good_freight'] += $value2['good_freight'];
                            }

                            // 总收入
                            $value['count_good_freight'] += $value2['good_freight'];
                        }
                    }

                    // 司机评价
                    $value['driver_comment'] = $this->comment_service->get_avg_driver_comment_by_id($value['driver_id']);

                    $this->data['stat_driver_data_list'][] = $value;
                }

                $this->data['stat_driver_data_list'] = multi_array_sort($this->data['stat_driver_data_list'], 'month_count_good_freight', SORT_DESC);
            }
        }

        // echo '<pre>';
        // print_r($this->data['stat_driver_data_list']);exit;

		$this->load->view($this->appfolder.'/main_view', $this->data);
	}

    public function ajax_get_week_data()
    {
        $error = array(
            'code' => 'success',
            'week_name' => array(),
            'week_data' => array(),
            'is_zero' => 0,
        );

        $start_time = $this->input->post('start_time', TRUE);
        $end_time = $this->input->post('end_time', TRUE);
        $stat_type = $this->input->post('stat_type', TRUE);

        $start_time = strtotime(date('Y-m-d 00:00:00', strtotime($start_time)));
        $end_time = strtotime(date('Y-m-d 23:59:59', strtotime($end_time)));

        if ($stat_type == 'order_go_out') { // 运单发车统计
            $where = array(
                'shipper_id' => $this->shipper_info['shipper_id'],
                'good_start_time >=' => $start_time,
                'good_start_time <=' => $end_time,
                'order_type' => array(4, 5),
            );
            $order_data_list = $this->orders_service->get_orders_data_list($where);
            if ($order_data_list) {
                foreach ($order_data_list as $value) {
                    $week = date('N', $value['good_start_time']);

                    if (isset($error['week_data'][$week])) {
                        $error['week_data'][$week] += 1;
                    } else {
                        $error['week_data'][$week] = 1;
                    }

                    $error['week_name'][$week]['day_name'] = '（'.date('m月d日', $value['good_start_time']).')';
                }
            }
        } elseif ($stat_type == 'order_freight') {  // 运单金额统计
            $where = array(
                'shipper_id' => $this->shipper_info['shipper_id'],
                'good_start_time >=' => $start_time,
                'good_start_time <=' => $end_time,
                'order_type' => array(4, 5),
            );
            $order_data_list = $this->orders_service->get_orders_data_list($where);
            if ($order_data_list) {
                foreach ($order_data_list as $value) {
                    $week = date('N', $value['good_start_time']);

                    if (isset($error['week_data'][$week])) {
                        $error['week_data'][$week] += $value['good_freight'];
                    } else {
                        $error['week_data'][$week] = $value['good_freight'];
                    }

                    if ($value['good_freight'] > 0) {
                        $error['is_zero'] = 1;
                    }

                    $error['week_name'][$week]['day_name'] = '（'.date('m月d日', $value['good_start_time']).')';
                }
            }
        }

        for ($i=0; $i < 7; $i++) {
            if (!isset($error['week_data'][$i+1])) {
                $error['week_data'][$i+1] = 0;
            }
        }

        for ($i=0; $i < 7; $i++) {
            if (!isset($error['week_name'][$i+1])) {
                $error['week_name'][$i+1]['day_name'] = '（'.date('m月d日', $start_time + $i * 86400).')';
            }
        }

        echo json_encode($error);
        exit;
    }

    public function ajax_get_month_data()
    {
        $error = array(
            'code' => 'success',
            'month_data' => array(),
        );

        $stat_type = $this->input->post('stat_type', TRUE);

        if ($stat_type == 'order_go_out') { // 运单发车统计
            $where = array(
                'shipper_id' => $this->shipper_info['shipper_id'],
                'order_type' => array(4, 5),
            );
            $order_data_list = $this->orders_service->get_orders_data_list($where);
            if ($order_data_list) {
                for ($i=1; $i <= 12; $i++) { 
                    $error['month_data'][$i] = 0;

                    foreach ($order_data_list as $value) {
                        $start_time = strtotime(date('Y-'.$i.'-01 00:00:00'));
                        $end_time = strtotime(date('Y-m-d 23:59:59', strtotime("".date('Y-'.$i.'-01 00:00:00')." +".(date('t', $start_time) - 1)." day")));

                        if ($value['good_start_time'] >= $start_time && $value['good_start_time'] <= $end_time) {
                            $error['month_data'][$i] += 1;
                        }
                    }
                }
            }
        } elseif ($stat_type == 'order_freight') {  // 运单金额统计
            $where = array(
                'shipper_id' => $this->shipper_info['shipper_id'],
                'order_type' => array(4, 5)
            );
            $order_data_list = $this->orders_service->get_orders_data_list($where);
            if ($order_data_list) {
                for ($i=1; $i <= 12; $i++) { 
                    $error['month_data'][$i] = 0;

                    foreach ($order_data_list as $value) {
                        $start_time = strtotime(date('Y-'.$i.'-01 00:00:00'));
                        $end_time = strtotime(date('Y-m-d 23:59:59', strtotime("".date('Y-'.$i.'-01 00:00:00')." +".(date('t', $start_time) - 1)." day")));

                        if ($value['good_start_time'] >= $start_time && $value['good_start_time'] <= $end_time) {
                            $error['month_data'][$i] += $value['good_freight'];
                        }
                    }
                }
            }
        } elseif ($stat_type == 'count_avg') {  // 每台车的平均收入和出车次数
            $where = array(
                'shipper_id' => $this->shipper_info['shipper_id'],
                'order_type' => array(4, 5)
            );
            $order_data_list = $this->orders_service->get_orders_data_list($where);
            if ($order_data_list) {
                for ($i=1; $i <= 12; $i++) { 
                    $error['month_data'][$i] = 0;

                    foreach ($order_data_list as $value) {
                        $start_time = strtotime(date('Y-'.$i.'-01 00:00:00'));
                        $end_time = strtotime(date('Y-m-d 23:59:59', strtotime("".date('Y-'.$i.'-01 00:00:00')." +".(date('t', $start_time) - 1)." day")));

                        if ($value['good_start_time'] >= $start_time && $value['good_start_time'] <= $end_time) {
                            $error['month_data'][$i] += $value['good_freight'];
                        }
                    }
                }
            }
        }

        echo json_encode($error);
        exit;
    }

    public function ajax_get_driver_anomaly()
    {
        $error = array(
            'code' => 'success',
        );

        $driver_anomaly_count = 0;
        $driver_anomaly_html = '';
        if (!empty($this->shipper_info['driver_ids'])) {
            $where = array(
                'company_id' => $this->shipper_info['company_id'],
                'status' => 1,
            );
            $driver_anomaly_data_list = $this->driver_anomaly_service->get_driver_anomaly_data_list($where);
            if ($driver_anomaly_data_list) {
                foreach ($driver_anomaly_data_list as $value) {
                    if ($value['is_view'] == 1) {
                        // 异常消息总数
                        $driver_anomaly_count += 1;
                    }

                    $where = array(
                        'driver_anomaly_id' => $value['id'],
                    );
                    $driver_anomaly_attachment_data_list = $this->driver_anomaly_service->get_driver_anomaly_attachment_data_list($where);

                    $driver_anomaly_img_list = array();
                    if ($driver_anomaly_attachment_data_list) {
                        foreach ($driver_anomaly_attachment_data_list as $value3) {
                            $attachment_data = $this->attachment_service->get_attachment_by_id($value3['attachment_id']);
                            $driver_anomaly_img_list[] = $attachment_data['http_file'];
                        }
                    }

                    $driver_data = $this->driver_service->get_driver_by_id($value['driver_id']);
                    $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_head_icon']);
                    $driver_data['driver_head_icon_http_file'] = $attachment_data['http_file'];

                    $where = array(
                        'driver_id' => $value['driver_id'],
                    );
                    $vehicle_data = $this->vehicle_service->get_vehicle_data($where);

                    $driver_anomaly_html .= '
                    <li>
                        <div>
                            <dl>
                                <dt>
                                    <img src="'.$driver_data['driver_head_icon_http_file'].'" width="50" height="50" align="left">
                                </dt>
                                <dd>
                                    "司机 "'.$driver_data['driver_name'].'，车牌 '.$vehicle_data['vehicle_card_num'].'<br />在 '.$value['province_name'].$value['city_name'].$value['exce_desc'].'。"
                                </dd>
                            </dl>
                        </div>
                        <div style="text-align:right;">'.date('Y年m月d日 H时i分', $value['cretime']).'</div>
                    </li>';
                }
            }
        }

        $error['driver_anomaly_count'] = $driver_anomaly_count;
        $error['driver_anomaly_html'] = $driver_anomaly_html;

        echo json_encode($error);
        exit;
    }

    public function ajax_update_anomaly_view()
    {
        $error = array(
            'code' => 'success',
        );

        $data = array(
            'is_view' => 2,
        );
        $where = array(
            'driver_id' => $this->shipper_info['driver_ids'],
        );
        $this->common_model->update('driver_anomaly', $data, $where);

        echo json_encode($error);
        exit;
    }

    public function ajax_update_anomaly_delete()
    {
        $error = array(
            'code' => 'success',
        );

        $where = array(
            'company_id' => $this->shipper_info['company_id'],
        );
        $this->common_model->delete('driver_anomaly', $where);

        echo json_encode($error);
        exit;
    }

    public function ajax_get_driver_avg_count()
    {
        $error = array(
            'code' => 'success',
            'data_list' => array(),
        );

        $driver_id = $this->input->post('driver_id', TRUE);

        $count_go_to = 0;
        $count_freight = 0;
        for ($i=0; $i<12; $i++) {
            $j = $i + 1;

            $error['data_list'][$i]['go_to'] = 0;
            $error['data_list'][$i]['avg_go_to'] = 0;
            $error['data_list'][$i]['freight'] = 0;
            $error['data_list'][$i]['avg_freight'] = 0;

            $first_day = date('Y-'.$j.'-01 00:00:00');
            $last_day  = date('Y-'.$j.'-d 23:59:59', strtotime("$first_day +1 month -1 day"));
            $first_time = strtotime($first_day);
            $last_time = strtotime($last_day);

            $where = array(
                'driver_id' => $driver_id,
                'order_type' => array(4, 5),
                'good_start_time >=' => $first_time,
                'good_start_time <=' => $last_time,
            );
            $order_data_list = $this->orders_service->get_orders_data_list($where);
            if (!empty($order_data_list)) {
                foreach ($order_data_list as $value) {
                    $error['data_list'][$i]['go_to'] += 1;
                    $error['data_list'][$i]['freight'] += $value['good_freight'];

                    $count_go_to += 1;
                    $count_freight += $value['good_freight'];
                }
            }
        }

        if (!empty($error['data_list'])) {
            foreach ($error['data_list'] as &$value) {
                if ($value['go_to']) {
                    $value['avg_go_to'] = sprintf("%0.1f", $value['go_to'] / 12);
                }

                if ($value['freight'] > 0) {
                    $value['avg_freight'] = sprintf("%0.2f", $value['freight'] / 12 / 10000).' 万';
                    $value['freight'] = sprintf("%0.2f", $value['freight'] / 10000).' 万';
                }
            }
        }

        echo json_encode($error);
        exit;
    }
}