<?php
use comm\Model\GsmLocation;

$func_gsm_location = function($packet, $message, $data_file_name) {
    $data = $message->_DATA;

    $gsmLocation_model = new GsmLocation($packet, $data, $data_file_name);
    $gsmLocation_model->save();


};
return $func_gsm_location;