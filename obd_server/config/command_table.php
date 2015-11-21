<?php

/**
 * 命令表
 */


return [
    'OTA_UPDATE_QUERY' => require_once __DIR__ . '/command/OTA_UPDATE_QUERY.php',

    'Truck_Information' => require_once __DIR__ . '/command/Truck_Information.php',
    'Backup_Truck_Information' => require_once __DIR__ . '/command/Backup_Truck_Information.php',
    'Event_Report' => require_once __DIR__ . '/command/Event_Report.php',
    'GSM_Location' => require_once __DIR__ . '/command/GSM_Location.php',
    'Device_Information' => require_once __DIR__ . '/command/Device_Information.php',
    'Sleep_Voltage_Record' => require_once __DIR__ . '/command/Sleep_Voltage_Record.php',
    'Truck_Acceleration_Information' => require_once __DIR__ . '/command/Truck_Acceleration_Information.php',

];