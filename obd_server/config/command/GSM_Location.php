<?php
use comm\Model\GsmLocation;

$func_gsm_location = function($packet, $message, $data_file_name) {
    $data = $message->_DATA;

    $gsmLocation_model = GsmLocation::getInstance($packet, $data);
    $gsmLocation_model->save();

    $gsmLocation_model->cached();


};
return $func_gsm_location;