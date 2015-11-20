<?php
use comm\Model\DeviceInformation;

$func_device_information= function($packet, $message, $data_file_name) {
    $data = $message->_DATA;
    $device_information_model = new DeviceInformation($packet, $data);
    $data = $device_information_model::$data;


    $var_str =  "VIN_code:" .$data['VIN_code'] ."\n" .
                'hardware_version:' . $data['hardware_version']. "\n".
                'software_version:' . $data['software_version']. "\n".
                'is_activated:' . $data['is_activated']. "\n".
                "wake_soure:" . $data['wake_soure']. "\n" .
                'obd_conf_version:'.$data['obd_conf_version'] ."\n";
    echo $var_str;

    file_put_contents($data_file_name.'MSG_' .$message->_MSG_ID, $var_str);

};

return $func_device_information;