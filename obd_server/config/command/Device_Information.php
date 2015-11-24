<?php
use comm\Model\DeviceInformation;

$func_device_information= function($packet, $message, $data_file_name) {
    $data = $message->_DATA;
    $device_information_model = DeviceInformation::getInstance($packet, $data);
    $device_information_model->save();

//    $device_information_model->cached();

    $device_information_model->echo_log($data_file_name, $message->_MSG_ID);

};

return $func_device_information;