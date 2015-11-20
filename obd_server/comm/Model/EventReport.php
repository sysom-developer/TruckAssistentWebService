<?php

namespace comm\Model;

use \comm\Model\BaseModel as Model;
use comm\Byte;


class EventReport extends Model{

    protected $table = 'event_report';

    public static $data = [];



    function __construct($packet, $data){

        $this->init($packet, $data);
        parent::__construct();
    }


    public function init($packet, $data){
        //引擎状态
        $engine_status = substr($data, 0, 1*2);
        //手刹状态
        $parking_brake_status = substr($data, 1*2, 1*2);
        //定速巡航状态
        $cruise_control_status = substr($data, 2*2, 1*2);
        //车辆电瓶电压值
        $car_battery_value = substr($data, 3*2, 2*2);
        $car_battery_value = Byte::ByteConvert($car_battery_value);
        //车辆电瓶电压状态
        $car_battery = substr($data, 5*2, 1*2);

        $longitude = substr($data, 6*2, 4*2);
        $ew_indicator = substr($data, 10*2, 1*2);

        $latitude = substr($data, 11*2, 4*2);
        $ns_indicator = substr($data, 15*2, 1*2);

        $gps_vehicle_speed = substr($data, 16*2, 1*2);

        $engine_speed = substr($data, 17*2, 2*2);

        $unix_time = substr($data, 19*2, 4*2);
        $unix_time = Byte::ByteConvert($unix_time);

        self::$data = [
            'engine_status' => $engine_status,
            'parking_brake_status' => $parking_brake_status,
            'cruise_control_status' => $cruise_control_status,
            'car_battery_value' => $car_battery_value,
            'car_battery' => $car_battery,

            'longitude' => $longitude,
            'ew_indicator' => $ew_indicator,
            'latitude' => $latitude,
            'ns_indicator' => $ns_indicator,

            'gps_vehicle_speed' => $gps_vehicle_speed,

            'engine_speed' => $engine_speed,

            'unix_time' => $unix_time,

            'device_id' => Byte::Hex2String($packet->_DEV_ID),
            'create_time' => time()
        ];


    }


    function save(){
        self::$_db->insert($this->table, self::$data);



    }

}