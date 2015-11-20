<?php
use comm\Byte;
use comm\Model\EventReport;
//引擎状态
$engine_status_conf = [
    '00' => 'off',//熄火
    '01' => 'on',//点火
    '02' => 'off to on event',//熄火变成点火
    '03' => 'sleeping'//睡眠
];

//手刹状态
$parking_brake_status_conf = [
    '00' => 'no set',//手刹拉上
    '01' => 'set',//手刹未拉
];

//定速巡航状态
$engine_status_conf = [
    '00' => 'off',//
    '01' => 'hold',//
    '02' => 'accelerate',//
    '03' => 'decelerate',//
    '04' => 'resume',
    '05' => 'set',
    '06' => 'accelerate override',
    '07' => 'not available',
];



$func_event_report = function($packet, $message,$data_file_name) {
    $data = $message->_DATA;

    $event_report_model = new EventReport($packet, $data);

    $event_report_model->save();
    $data = EventReport::$data;

    $data_str = 'engine_status:' .$data['engine_status'] ."\n".
        'parking_brake_status:' .$data['parking_brake_status']."\n".
        'cruise_control_status:' .$data['cruise_control_status']."\n" .
        'car_battery_value:'.$data['car_battery_value']."\n".
        'car_battery:'.$data['car_battery']."\n".
        'longitude :'.$data['longitude']."\n" .
        'ew_indicator:' .$data['ew_indicator'] ."\n".
        'latitude:'.$data['latitude'] ."\n".
        'ns_indicator:' .$data['ns_indicator'] ."\n" .
        'gps_vehicle_speed'. $data['gps_vehicle_speed'] ."\n".
        'engine_speed:' .$data['engine_speed'] ."\n" .
        'unix_time:' .$data['unix_time'] ."\n";

    file_put_contents($data_file_name .'MSG_' .$message->_MSG_ID, $data_str);


};
return $func_event_report;