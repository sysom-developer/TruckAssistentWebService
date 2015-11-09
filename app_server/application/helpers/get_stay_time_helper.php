<?php 

/**
 * 返回多少日多少天
 */
if ( ! function_exists('get_stay_time'))
{
    function get_stay_time($timestamp, $is_hour = 1, $is_minutes = 1, $is_current = 1)
    {
        $CI =& get_instance();

        if(empty($timestamp) || $timestamp <= 60) {
            return false;
        }

        $time = time();

        $remain_time = $timestamp;
        if ($is_current == 1) {
            $remain_time = $time - $timestamp;
        }

        $day = floor($remain_time / (3600*24));
        $day = $day > 0 ? $day.'天' : '';
        $hour = floor(($remain_time % (3600*24)) / 3600);
        $hour = $hour > 0 ? $hour.'小时' : '';
        if($is_hour && $is_minutes) {
            $minutes = floor((($remain_time % (3600*24)) % 3600) / 60);
            $minutes = $minutes > 0 ? $minutes.'分' : '';
            return $day.$hour.$minutes;
        }

        if($hour) {
            return $day.$hour;
        }
        return $day;
    }
}