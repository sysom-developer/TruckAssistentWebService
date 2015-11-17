<?php
$func_sleep_voltage_record = function($packet, $message,$data_file_name) {
    $data = $message->_DATA;
    $valid_flag = substr($data, 0, 5*2);

    $timestamp_1 = substr($data, 6*2, 4*2);
    $voltage_saved_1 = substr($data, 10*2, 2*2);
    $voltage_saved_arr_1 = str_split($voltage_saved_1, 2);
    $voltage_saved_1 = implode('', array_reverse($voltage_saved_arr_1));

    $timestamp_2 = substr($data, 12*2, 4*2);
    $voltage_saved_2 = substr($data, 14*2, 2*2);
    $voltage_saved_arr_2 = str_split($voltage_saved_2, 2);
    $voltage_saved_2 = implode('', array_reverse($voltage_saved_arr_2));

    $timestamp_3 = substr($data, 16*2, 4*2);
    $voltage_saved_3 = substr($data, 20*2, 2*2);
    $voltage_saved_arr_3 = str_split($voltage_saved_3, 2);
    $voltage_saved_3 = implode('', array_reverse($voltage_saved_arr_3));

    $timestamp_4 = substr($data, 22*2, 4*2);
    $voltage_saved_4 = substr($data, 26*2, 2*2);
    $voltage_saved_arr_4 = str_split($voltage_saved_4, 2);
    $voltage_saved_4 = implode('', array_reverse($voltage_saved_arr_4));

    $timestamp_5 = substr($data, 28*2, 4*2);
    $voltage_saved_5 = substr($data, 32*2, 2*2);
    $voltage_saved_arr_5 = str_split($voltage_saved_5, 2);
    $voltage_saved_5 = implode('', array_reverse($voltage_saved_arr_5));

    $timestamp_6 = substr($data, 34*2, 4*2);
    $voltage_saved_6 = substr($data, 38*2, 2*2);
    $voltage_saved_arr_6 = str_split($voltage_saved_6, 2);
    $voltage_saved_6 = implode('', array_reverse($voltage_saved_arr_6));



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