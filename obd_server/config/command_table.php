<?php

/**
 * 命令表
 */


return [
    'OTA_UPDATE_QUERY' => require_once __DIR__ . '/command/OTA_UPDATE_QUERY.php',
    'CRASH' => require_once __DIR__ . '/command/CRASH.php',
    'BASE_INFO' => require_once __DIR__ . '/command/BASE_INFO.php',
    'VERSION_INFO' => require_once __DIR__ . '/command/VERSION_INFO.php',
    'EVENT_STATUS' => require_once __DIR__ . '/command/EVENT_STATUS.php',
    'ENGINE_START_UP' => require_once __DIR__ . '/command/ENGINE_START_UP.php',//$func_engine_start_up,
    'DTC_FAULT' => require_once __DIR__ . '/command/DTC_FAULT.php',//$func_otc_fault,

    'GPS_BACK_UP' => require_once __DIR__ . '/command/GPS_BACK_UP.php',//$func_gps_back_up,
    'GSM' => require_once __DIR__ . '/command/GSM.php',//$func_gsm,
    'MILEAGE_INFO' => require_once __DIR__ . '/command/MILEAGE_INFO.php',//$func_mileage,

    'VOLTAGE' => require_once __DIR__ . '/command/VOLTAGE.php',//$func_voltage,
    'POWER' => require_once __DIR__ . '/command/POWER.php',//$func_power,



    'Truck_Information' => require_once __DIR__ . '/command/Truck_Information.php',
    'Event_Report' => require_once __DIR__ . '/command/Event_Report.php',
    'GSM_Location' => require_once __DIR__ . '/command/GSM_Location.php',
    'Device_Information' => require_once __DIR__ . '/command/Device_Information.php',
    'Sleep_Voltage_Record' => require_once __DIR__ . '/command/Sleep_Voltage_Record.php',
];