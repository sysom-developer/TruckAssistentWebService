<?php

use comm\Model\TrunckInformation;

$func_backup_truck_information = function($packet, $message, $data_file_name) {
    $data = $message->_DATA;

    $trunck_information_model = TrunckInformation::getInstance($packet, $data);

    $trunck_information_model->save();

    $trunck_information_model->echo_log($data_file_name, $message->_MSG_ID);


};
return $func_backup_truck_information;