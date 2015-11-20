<?php

namespace comm\Model;

use \comm\Model\BaseModel as Model;
use comm\Byte;


class DeviceInformation extends Model{

    protected $table = 'device_information';

    public static $data = [];


    function __construct($packet, $data){

        $this->init($packet, $data);
        parent::__construct();
    }


    public function init($packet, $data){
        $VIN_code = substr($data, 0, 17*2);

        $hardware_version_LSB = chr(hexdec(substr($data, 17*2, 1*2)));
        $hardware_version_MSB = chr(hexdec(substr($data, 18*2, 1*2)));

        $software_version_LSB = chr(hexdec(substr($data, 19*2, 1*2)));
        $software_version_MSB = chr(hexdec(substr($data, 20*2, 1*2)));

        $is_activated = substr($data, 21*2, 1*2);

        $wake_soure = substr($data, 22*2, 1*2);

        $obd_conf_version = substr($data, 23*2, 1*2);

        self::$data = [
            'VIN_code' => $VIN_code,
            'hardware_version' => $hardware_version_MSB . '.' . $hardware_version_LSB,
            'software_version' => $software_version_MSB . $software_version_LSB,
            'is_activated' => $is_activated,
            'wake_soure' => $wake_soure,

            'obd_conf_version' => $obd_conf_version,

            'device_id' => Byte::Hex2String($packet->_DEV_ID),
            'create_time' => time()
        ];

    }


    function save(){
        var_dump(self::$data);
        self::$_db->insert($this->table, self::$data);

    }

}