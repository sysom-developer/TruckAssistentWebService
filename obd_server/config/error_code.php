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
        '23' => 'ACTIVATE',//激活
        '29' => 'OTA',//升级
        '37' => 'AGPS',//发送星历数据

        '2a' => 'OTA_UPDATE_QUERY',//升级查询请求
        '2b' => 'CRASH',//车辆碰撞
        '2c' => 'BASE_INFO',
        '2e' => 'VERSION_INFO',
        '2f' => 'EVENT_STATUS',
        '30' => 'ENGINE_START_UP',
        '31' => 'DTC_FAULT',
        '33' => '',
        '35' => 'GPS_BACK_UP',
        '36' => 'GSM',//获取APGS信息
        '38' => 'MILEAGE_INFO',
        '26' => 'VOLTAGE',// 电压
        '3a' => 'POWER'//断电恢复信息
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
