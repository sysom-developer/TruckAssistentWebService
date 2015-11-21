<?php


/**
 * 指令编码
 */

return [

    'SEP' => '1c',

    'FID' => [
        '01' => 'START_UP',//启动
        '02' => 'LOCATION',// 定位
        '03' => 'ACCELERATION',//加速度
        '04' => 'ANGLE',//角度
        '10' => 'DIAGNOSIS',// 诊断
        '20' => 'OTA',// 升级
    ],//上传的场景

    'MSG_ID' => [

        '02' => 'Device_Information',
        '20' => 'Truck_Acceleration_Information',
        '21' => 'Truck_Information',
        '22' => 'Event_Report',
        '23' => 'Backup_Truck_Information',
        '2a' => 'OTA_UPDATE_QUERY',//升级查询请求
        '40' => 'GSM_Location',
        '24' => 'Sleep_Voltage_Record',

    ],//消息处理

    'STATE' => [
        'STATE_RECV_OK' => 0x30,//返回给客户端接收成功
        'STATE_RECV_NG' => 0x31,
        'STATE_EXEC_OK' => 0x32,
        'STATE_EXEC_NG' => 0x33,

        '30' => 'STATE_RECV_OK',
        '31' => 'STATE_RECV_NG',
        '32' => 'STATE_EXEC_OK',
        '33' => 'STATE_EXEC_NG',
    ],
];
