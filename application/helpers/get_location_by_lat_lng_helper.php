<?php 

/**
 * 根据经纬获取位置信息
 * @param  string $lat 纬度
 * @param  string $lng 经度
 * @return string      位置信息
 */

if ( ! function_exists('get_location_by_lat_lng'))
{
    function get_location_by_lat_lng($lat, $lng)
    {
        $CI =& get_instance();
        
        $url = "http://api.map.baidu.com/geocoder/v2/";
        $params = array(
            'location' => $lat.",".$lng,
            'output' => 'json',
            'ak' => BAIDU_AK,
            'pois' => 1,
        );
        $response = $CI->curl->_simple_call('get', $url, $params);
        $response = json_decode($response, TRUE);

        $address = '';
        if (isset($response['result'])) {
            $address = $response['result']['addressComponent']['city'];
        }

        return $address;
    }
}