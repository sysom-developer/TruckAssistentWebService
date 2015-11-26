<?php
use comm\Model\DeviceInformation;
use comm\Response_Message;

$func_device_information= function($packet, $message, $data_file_name) {
    $data = $message->_DATA;
    $device_information_model = DeviceInformation::getInstance($packet, $data);
    $device_information_model->save();

//    $device_information_model->cached();

    $device_information_model->echo_log($data_file_name, $message->_MSG_ID);

    $is_activated = intval($device_information_model::$data['is_activated']);
    if(!empty($is_activated)){//已激活
        $response_message = new Response_Message(0x01, 0x55);
        $result = $response_message->getResponse();
        return $result;
    }else{//未激活，发送激活
        $response_message = new Response_Message(0x01, 0x00);
        $result = $response_message->getResponse();
        return $result;
    }

};

return $func_device_information;