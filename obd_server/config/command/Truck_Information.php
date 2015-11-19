<?php

use comm\Byte;

$func_truck_information = function($packet, $message, $data_file_name) {
    $data = $message->_DATA;

    $longitude = substr($data, 0, 4*2);

    $ew_indicator = substr($data, 4*2, 1*2);

    $latitude = substr($data, 5*2, 4*2);

    $ns_indicator = substr($data, 9*2, 1*2);

    $gps_vehicle_speed = substr($data, 10*2, 1*2);

    $engine_speed = substr($data, 11*2, 2*2);

    $unix_time = substr($data, 13*2, 4*2);

    $gps_data_status = substr($data, 17*2, 1*2);

    //发动机扭转百分比
    $percent_torque = substr($data, 18*2, 1*2);

    //发动机负载百分比
    $engine_percent_load = substr($data, 19*2, 1*2);

    //加速踏板位置百分比
    $accelerator = substr($data, 20*2, 1*2);

    //刹车踏板位置百分比
    $brake_pedal_position = substr($data, 21*2, 1*2);

    //瞬时油耗
    $fuel_rate = substr($data, 22*2, 2*2);
    $fuel_rate = Byte::ByteConvert($fuel_rate);

    //冷却液温度
    $engine_coolant_temperature = substr($data, 24*2, 1*2);

    //进气歧管压力
    $air_inlet_pressure = substr($data, 25*2, 1*2);

    //机油压力
    $engine_oil_pressure = substr($data, 26*2, 1*2);

    //基于转速传感器的车速
    $wheel_based_vehicle_speed = substr($data, 27*2, 2*2);
    $wheel_based_vehicle_speed = Byte::ByteConvert($wheel_based_vehicle_speed);

    //燃油温度
    $fuel_temperature = substr($data, 29*2, 1*2);

    //机油温度
    $engine_oil_temperature = substr($data, 30*2, 2*2);
    $engine_oil_temperature = Byte::ByteConvert($engine_oil_temperature);

    //进气温度
     $inlet_air_temperature = substr($data, 32*2, 1*2);

    $data_str = '$longitude:' .$longitude ."\n".
        'ew_indicator:' .$ew_indicator."\n".
        'latitude:' .$latitude."\n" .
        'ns_indicator:'.$ns_indicator."\n".
        'gps_vehicle_speed:'.$gps_vehicle_speed."\n".
        'engine_speed :'.$engine_speed."\n" .

        'unix_time:' .$unix_time ."\n".
        'gps_data_status:' .$gps_data_status ."\n".
        'percent_torque:' .$percent_torque ."\n".
        'engine_percent_load:' .$engine_percent_load ."\n".
        'accelerator:' .$accelerator ."\n".
        'brake_pedal_position:' .$brake_pedal_position ."\n".
        'fuel_rate:' .$fuel_rate ."\n".
        'engine_coolant_temperature:' .$engine_coolant_temperature ."\n".
        'air_inlet_pressure:' .$air_inlet_pressure ."\n".
        'engine_oil_pressure:' .$engine_oil_pressure ."\n".
        'wheel_based_vehicle_speed:' .$wheel_based_vehicle_speed ."\n".
        'fuel_temperature:' .$fuel_temperature ."\n".
        'engine_oil_temperature:' .$engine_oil_temperature ."\n".
        'inlet_air_temperature:' .$inlet_air_temperature ."\n";

    echo $data_str . PHP_EOL;


    file_put_contents($data_file_name .'MSG_' .$message->_MSG_ID, $data_str);

};
return $func_truck_information;