<?php

use comm\Model\TrunckInformation;

$func_backup_truck_information = function($packet, $message, $data_file_name) {
    $data = $message->_DATA;

    $trunck_information_model = new TrunckInformation($packet, $data);
    $trunck_information_model->save();
    $data = $trunck_information_model::$data;


    $data_str = '$longitude:' .$data['longitude'] ."\n".
        'ew_indicator:' .$data['ew_indicator']."\n".
        'latitude:' .$data['latitude']."\n" .
        'ns_indicator:'.$data['ns_indicator']."\n".
        'gps_vehicle_speed:'.$data['gps_vehicle_speed']."\n".
        'engine_speed :'.$data['engine_speed']."\n" .

        'unix_time:' .$data['unix_time'] ."\n".
        'gps_data_status:' .$data['gps_data_status'] ."\n".
        'percent_torque:' .$data['percent_torque'] ."\n".
        'engine_percent_load:' .$data['engine_percent_load'] ."\n".
        'accelerator:' .$data['$accelerator'] ."\n".
        'brake_pedal_position:' .$data['brake_pedal_position'] ."\n".
        'fuel_rate:' .$data['fuel_rate'] ."\n".
        'engine_coolant_temperature:' .$data['engine_coolant_temperature'] ."\n".
        'air_inlet_pressure:' .$data['air_inlet_pressure'] ."\n".
        'engine_oil_pressure:' .$data['engine_oil_pressure'] ."\n".
        'wheel_based_vehicle_speed:' .$data['wheel_based_vehicle_speed'] ."\n".
        'fuel_temperature:' .$data['fuel_temperature'] ."\n".
        'engine_oil_temperature:' .$data['engine_oil_temperature'] ."\n".
        'inlet_air_temperature:' .$data['inlet_air_temperature'] ."\n";

    echo $data_str . PHP_EOL;


    file_put_contents($data_file_name .'MSG_' .$message->_MSG_ID, $data_str);

};
return $func_backup_truck_information;