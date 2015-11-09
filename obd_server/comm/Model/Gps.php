<?php

namespace comm\Model;

use \comm\Model\BaseModel as Model;


class Gps extends Model{

    protected $table = 'gps_data';

    function save(){
        $data = ['create_time' => time(), 'is_location' => 1];
        self::$_db->insert($this->table, $data);
    }

}