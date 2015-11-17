<?php
$func_device_information= function($packet, $message, $data_file_name) {
    $data = $message->_DATA;
    $VIN_code = substr($data, 0, 17*2);

    $hardware_version_LSB = chr(hexdec(substr($data, 17*2, 1*2)));
    $hardware_version_MSB = chr(hexdec(substr($data, 18*2, 1*2)));

    $software_version_LSB = chr(hexdec(substr($data, 19*2, 1*2)));
    $software_version_MSB = chr(hexdec(substr($data, 20*2, 1*2)));


    $is_activated = substr($data, 21*2, 1*2);

    $wake_soure = substr($data, 22*2, 1*2);

    $obd_conf_version = substr($data, 23*2, 1*2);

    $var_str =  "VIN_code:" .$VIN_code ."\n" .
                'hardware_version:' . $hardware_version_MSB.'.'.$hardware_version_LSB. "\n".
                'software_version:' . $software_version_MSB.$software_version_LSB. "\n".
                'is_activated:' . $is_activated. "\n".
                "wake_soure:" . $wake_soure. "\n" .
                'wake_soure:'.$wake_soure ."\n".
                'obd_conf_version:'.$obd_conf_version ."\n";
    echo $var_str;

    file_put_contents($data_file_name.'MSG_' .$message->_MSG_ID, $var_str);

};

return $func_device_information;