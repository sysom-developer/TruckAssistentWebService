<?php 

/**
 * 
 * 获取一年中的每星期的开始日期和结束日期
 */

if ( ! function_exists('get_week'))
{
    function get_week($year_start, $year_end)
    {
        $CI =& get_instance();
        
        $startday = strtotime($year_start); 
        if (intval(date('N', $startday)) != '1') { 
            $startday = strtotime("next monday", strtotime($year_start)); //获取年第一周的日期 
        }
        $year_mondy = date("Y-m-d", $startday); //获取年第一周的日期 

        $endday = strtotime($year_end); 
        if (intval(date('W', $endday)) == '7') { 
            $endday = strtotime("last sunday", strtotime($year_end)); 
        } 
     
        $current_week = intval(date("W"));
        $num = intval(date('W', $endday)); 
        $is_current_date = 0;
        for ($i = 1; $i <= $num; $i++) { 
            $j = $i -1; 
            $start_date = date("Y-m-d", strtotime("$year_mondy $j week ")); 
            $end_day = date("Y-m-d", strtotime("$start_date +6 day")); 

            if (strtotime("$year_mondy $j week ") > $endday) {
                break;
            }

            if (intval(date("W", strtotime($start_date))) == $current_week) {
                $is_current_date = 1;
            }

            $r_start_date = date("n月j日", strtotime($start_date));
            $r_end_day = date("n月j日", strtotime($end_day));
     
            $week_array[$i] = array($r_start_date, $r_end_day, $start_date, $end_day, $is_current_date); 
        } 
        return $week_array;
    }
}