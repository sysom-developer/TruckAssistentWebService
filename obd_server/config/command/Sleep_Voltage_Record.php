<?php
use comm\Byte;

$func_sleep_voltage_record = function($packet, $message,$data_file_name) {
    $data = $message->_DATA;
    $valid_flag = substr($data, 0, 6*2);

    $timestamp_1 = substr($data, 6*2, 4*2);
    $voltage_saved_1 = substr($data, 10*2, 2*2);
    $voltage_saved_1 = Byte::ByteConvert($voltage_saved_1);

    $timestamp_2 = substr($data, 12*2, 4*2);
    $voltage_saved_2 = substr($data, 16*2, 2*2);
    $voltage_saved_2 = Byte::ByteConvert($voltage_saved_2);

    $timestamp_3 = substr($data, 18*2, 4*2);
    $voltage_saved_3 = substr($data, 22*2, 2*2);
    $voltage_saved_3 = Byte::ByteConvert($voltage_saved_3);

    $timestamp_4 = substr($data, 24*2, 4*2);
    $voltage_saved_4 = substr($data, 28*2, 2*2);
    $voltage_saved_4 = Byte::ByteConvert($voltage_saved_4);

    $timestamp_5 = substr($data, 30*2, 4*2);
    $voltage_saved_5 = substr($data, 34*2, 2*2);
    $voltage_saved_5 = Byte::ByteConvert($voltage_saved_5);

    $timestamp_6 = substr($data, 36*2, 4*2);
    $voltage_saved_6 = substr($data, 40*2, 2*2);
    $voltage_saved_6 = Byte::ByteConvert($voltage_saved_6);



    $data_str = 'valid_flag:' .$valid_flag ."\n".
        'timestamp_1:' .$timestamp_1."\n".
        'voltage_saved_1:' .$voltage_saved_1."\n" .

        'timestamp_2:'.$timestamp_2."\n".
        'voltage_saved_2:'.$voltage_saved_2."\n".

        'timestamp_3:'.$timestamp_3."\n".
        'voltage_saved_3:'.$voltage_saved_3."\n".

        'timestamp_4:'.$timestamp_4."\n".
        'voltage_saved_4:'.$voltage_saved_4."\n".

        'timestamp_5:'.$timestamp_5."\n".
        'voltage_saved_5:'.$voltage_saved_5."\n".

        'timestamp_6:'.$timestamp_6."\n".
        'voltage_saved_6:'.$voltage_saved_6."\n";


    file_put_contents($data_file_name .'MSG_' .$message->_MSG_ID, $data_str);


};
return $func_sleep_voltage_record;