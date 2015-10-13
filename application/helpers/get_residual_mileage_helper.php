<?php 

if ( ! function_exists('get_residual_mileage'))
{
    function get_residual_mileage($start_lat, $start_lng, $end_lat, $end_lng)
    {
        $CI =& get_instance();
        
        $url = "http://api.map.baidu.com/direction/v1/routematrix";
        $params = array(
            'origins' => $start_lat.','.$start_lng,
            'destinations' => $end_lat.','.$end_lng,
            'output' => 'json',
            'ak' => BAIDU_AK,
            'pois' => 1,
        );
        $response = $CI->curl->_simple_call('get', $url, $params);
        $response = json_decode($response, TRUE);

        return $response;
    }
}