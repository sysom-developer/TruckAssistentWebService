<?php

namespace comm\Model;

use \comm\Model\BaseModel as Model;
use comm\Byte;


class GsmLocation extends Model{

    protected $table = 'gsm_location';

    private static $data = [];


    function __construct($packet, $data, $data_file_name){

        $this->init($packet, $data);
        parent::__construct();
    }


    public function init($packet, $data){
        $longitude = substr($data, 0, 6*2);
        $latitude = substr($data, 6*2, 5*2);
        $gps_data_status = substr($data, 11*2, 1*2);
        $unix_time = substr($data, 12*2, 4*2);

        self::$data = [
            'longitude' => $longitude,
            'latitude' => $latitude,
            'gps_data_status' => $gps_data_status,
            'unix_time' => $unix_time,

            'device_id' => Byte::Hex2String($packet->_DEV_ID),
            'create_time' => time()
        ];

    }


    function save(){

        self::$_db->insert($this->table, self::$data);

    }

}