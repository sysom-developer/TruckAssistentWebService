<?php

namespace comm\Model;

use \comm\Model\BaseModel as Model;
use comm\Byte;


class TrunckAccelerationInformation extends Model{

    protected $table = 'trunck_acceleration_information';

    public static $data = [];
    private static $_instance;

    public static function getInstance($packet, $data){

        if(!(self::$_instance instanceof self)) {
            self::$_instance = new TrunckAccelerationInformation($packet, $data);
        }
        return self::$_instance;
    }

    function __construct($packet, $data){

        $this->init($packet, $data);
        parent::__construct();
    }


    public function init($packet, $data){
        $axis_arr = [];

        $num = substr($data, 0, 1*2);

        $axis_data = substr($data, 1*2);
        $axis_origin_data = str_split($axis_data, 6*2);
        array_walk($axis_origin_data, function($v) use (&$axis_arr){
            $tmp = [
                'x_axis' => Byte::ByteConvert(substr($v, 0, 2*2)),
                'y_axis' => Byte::ByteConvert(substr($v, 2*2, 2*2)),
                'z_axis' => Byte::ByteConvert(substr($v, 4*2, 2*2)),
            ];
            $axis_arr[] = $tmp;

        });


        self::$data = [

            'device_id' => Byte::Hex2String($packet->_DEV_ID),
            'create_time' => time()
        ];

    }


    function save(){
//        self::$_db->insert($this->table, self::$data);
    }

}