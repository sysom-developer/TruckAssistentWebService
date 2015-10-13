<?php

/**
 * 根据地址获取经纬度
 * @param  string $location 地址
 * @return array          经纬度 lng 经度 lat 纬度
 */
if ( ! function_exists('get_lat_lng_by_location'))
{
    function get_lat_lng_by_location($location) 
    {
        $CI =& get_instance();
        
        $url = "http://api.map.baidu.com/geocoder/v2/";
        $params = array(
            'address' => $location,
            'output' => 'json',
            'ak' => BAIDU_AK,
        );
        $response = $CI->curl->_simple_call('get', $url, $params);
        $response = json_decode($response, TRUE);

        $rtn = array(
            'lng' => $response['result']['location']['lng'],
            'lat' => $response['result']['location']['lat'],
        );

        return $rtn;
    }
}