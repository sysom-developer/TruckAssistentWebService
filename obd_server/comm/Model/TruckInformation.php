<?php

namespace comm\Model;

use \comm\Model\BaseModel as Model;
use comm\Byte;


class TrunckInformation extends Model{

    protected $table = 'trunck_information';

    public static $data = [];

    function __construct($packet, $data){

        $this->init($packet, $data);
        parent::__construct();
    }


    public function init($packet, $data){
        $longitude = substr($data, 0, 4*2);

        $ew_indicator = substr($data, 4*2, 1*2);

        $latitude = substr($data, 5*2, 4*2);

        $ns_indicator = substr($data, 9*2, 1*2);

        $gps_vehicle_speed = substr($data, 10*2, 1*2);

        $engine_speed = substr($data, 11*2, 2*2);

        $unix_time = substr($data, 13*2, 4*2);

        $gps_data_status = substr($data, 17*2, 1*2);

        //发动机扭转百分比
        $percent_torque = substr($data, 18*2, 1*2);

        //发动机负载百分比
        $engine_percent_load = substr($data, 19*2, 1*2);

        //加速踏板位置百分比
        $accelerator = substr($data, 20*2, 1*2);

        //刹车踏板位置百分比
        $brake_pedal_position = substr($data, 21*2, 1*2);

        //瞬时油耗
        $fuel_rate = substr($data, 22*2, 2*2);
        $fuel_rate = Byte::ByteConvert($fuel_rate);

        //冷却液温度
        $engine_coolant_temperature = substr($data, 24*2, 1*2);

        //进气歧管压力
        $air_inlet_pressure = substr($data, 25*2, 1*2);

        //机油压力
        $engine_oil_pressure = substr($data, 26*2, 1*2);

        //基于转速传感器的车速
        $wheel_based_vehicle_speed = substr($data, 27*2, 2*2);
        $wheel_based_vehicle_speed = Byte::ByteConvert($wheel_based_vehicle_speed);

        //燃油温度
        $fuel_temperature = substr($data, 29*2, 1*2);

        //机油温度
        $engine_oil_temperature = substr($data, 30*2, 2*2);
        $engine_oil_temperature = Byte::ByteConvert($engine_oil_temperature);

        //进气温度
        $inlet_air_temperature = substr($data, 32*2, 1*2);

        self::$data = [
            'longitude' => $longitude,
            'ew_indicator' => $ew_indicator,
            'latitude' => $latitude,
            'ns_indicator' => $ns_indicator,
            'gps_vehicle_speed' => $gps_vehicle_speed,
            'engine_speed' => $engine_speed,
            'unix_time' => $unix_time,
            'gps_data_status' => $gps_data_status,
            'percent_torque' => $percent_torque,
            'engine_percent_load' => $engine_percent_load,
            'accelerator' => $accelerator,
            'brake_pedal_position' => $brake_pedal_position,
            'fuel_rate' => $fuel_rate,
            'engine_coolant_temperature' => $engine_coolant_temperature,
            'air_inlet_pressure' => $air_inlet_pressure,
            'engine_oil_pressure' => $engine_oil_pressure,
            'wheel_based_vehicle_speed' => $wheel_based_vehicle_speed,
            'fuel_temperature' => $fuel_temperature,
            'engine_oil_temperature' => $engine_oil_temperature,
            'inlet_air_temperature' => $inlet_air_temperature,

            'device_id' => Byte::Hex2String($packet->_DEV_ID),
            'create_time' => time()
        ];

    }


    function save(){
        self::$_db->insert($this->table, self::$data);
    }

}