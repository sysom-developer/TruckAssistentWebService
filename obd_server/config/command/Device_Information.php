<?php
$func_device_information= function($packet, $message, $data_file_name) {
    $data = $message->_DATA;
    $VIN_code = substr($data, 0, 16*2);

    $wake_soure = substr($data, 22*2, 1*2);

    $var_str = "VIN_code:" .$VIN_code ."\n" . "wake_soure:" . $wake_soure. "\n";

    file_put_contents($data_file_name.'MSG_' .$message->_MSG_ID, $var_str);

};

return $func_device_information;