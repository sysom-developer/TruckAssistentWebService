<?php

namespace comm\Model;

use comm\Cache\MyRedis;
use \comm\Model\BaseModel as Model;
use comm\Byte;


class GsmLocation extends Model{

    protected $table = 'gsm_location';

    private static $data = [];
    private static $_instance;

    public static function getInstance($packet, $data){

        if(!(self::$_instance instanceof self)) {
            self::$_instance = new GsmLocation($packet, $data);
        }
        return self::$_instance;
    }


    function __construct($packet, $data){

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

    function cached(){
        $my_redis = MyRedis::getInstance();

        $data = self::$data;
        $s_key = 'DevId:'.$data['device_id'];
        $h_key = 'Gsm_Location:'.$data['create_time'];

        $my_redis->sadd($s_key, $h_key);
        $my_redis->hMset($h_key, $data);
    }

}