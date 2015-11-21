<?php
use comm\Byte;
use comm\Model\SleepVoltageRecord;

$func_sleep_voltage_record = function($packet, $message,$data_file_name) {
    $data = $message->_DATA;

    $sleepVoltageRecord_model = new SleepVoltageRecord($packet, $data, $data_file_name);
    $sleepVoltageRecord_model->save();


};
return $func_sleep_voltage_record;