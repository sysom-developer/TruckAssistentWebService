<?php

/**
 * 年 + 月 + 日 + 专线公司自增id + 当前专线公司第几单
 */
if ( ! function_exists('get_order_sn'))
{
    function get_order_sn($shipper_id) {
        $CI =& get_instance();
        
        // 年月日
        $order_sn = date("ymd");

        // 专线公司自增id
        $shipper_id = str_pad($shipper_id, 3, '0', STR_PAD_LEFT);
        $order_sn .= $shipper_id;

        // 当前专线公司第几单
        $first_day = date('Y-m-01 00:00:00');
        $last_day  = date('Y-m-d 23:59:59', strtotime("$first_day +1 month -1 day"));
        $first_time = strtotime($first_day);
        $last_time = strtotime($last_day);
        $where = array(
            'shipper_id' => $shipper_id,
            'create_time >=' => $first_time,
            'create_time <=' => $last_time, 
        );
        $order_data_list = $CI->orders_service->get_orders_data_list($where);
        $count = count($order_data_list) + 1;
        $count = str_pad($count, 3, '0', STR_PAD_LEFT);

        $order_sn .= $count;

        return $order_sn;
    }
}