<?php
use comm\Byte;
$func_event_report = function($packet, $message,$data_file_name) {
    $data = $message->_DATA;
    $engine_status = substr($data, 0, 1*2);
    $parking_brake_status = substr($data, 1*2, 1*2);
    $cruise_control_status = substr($data, 2*2, 1*2);

    $car_battery_value = substr($data, 3*2, 2*2);
    $car_battery_value = Byte::ByteConvert($car_battery_value);

    $car_battery = substr($data, 5*2, 1*2);
    $longitude = substr($data, 6*2, 4*2);
    $ew_indicator = substr($data, 10*2, 1*2);
    $latitude = substr($data, 11*2, 4*2);
    $ns_indicator = substr($data, 15*2, 1*2);

    $gps_vehicle_speed = substr($data, 16*2, 1*2);

    $engine_speed = substr($data, 17*2, 2*2);

    $unix_time = substr($data, 19*2, 4*2);
    $unix_time = Byte::ByteConvert($unix_time);

    $data_str = 'engine_status:' .$engine_status ."\n".
        'parking_brake_status:' .$parking_brake_status."\n".
        'cruise_control_status:' .$cruise_control_status."\n" .
        'car_battery_value:'.$car_battery_value."\n".
        'car_battery:'.$car_battery."\n".
        'longitude :'.$longitude."\n" .
        'ew_indicator:' .$ew_indicator ."\n".
        'latitude:'.$latitude ."\n".
        'ns_indicator:' .$ns_indicator ."\n" .
        'gps_vehicle_speed'. $gps_vehicle_speed ."\n".
        'engine_speed:' .$engine_speed ."\n" .
        'unix_time' .$unix_time ."\n";

    file_put_contents($data_file_name .'MSG_' .$message->_MSG_ID, $data_str);


};
return $func_event_report;