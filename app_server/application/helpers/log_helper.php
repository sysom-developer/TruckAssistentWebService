<?php 

/**
 * 日志操作
 */

if ( ! function_exists('insert_admin_log'))
{
    function insert_admin_log($log_type, $log_remark, $admin_id)
    {
        $CI =& get_instance();
        
        $data = array(
            'log_type' => $log_type,
            'log_remark' => $log_remark,
            'admin_id' => $admin_id,
            'cretime' => time(),
        );
        $insert_id = $CI->common_model->insert('admin_log', $data);

        return $insert_id;
    }
}

if ( ! function_exists('get_admin_log_type')) {
    function get_admin_log_type($log_type)
    {
        $CI =& get_instance();

        $admin_log_type = $CI->config->item('admin_log_type');

        return $admin_log_type[$log_type];
    }
}