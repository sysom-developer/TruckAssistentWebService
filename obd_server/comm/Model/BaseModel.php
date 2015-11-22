<?php

namespace comm\Model;

class BaseModel{

    protected static $_db = null;

    function __construct(){

        if(!(self::$_db instanceof \medoo)) {
            self::$_db = new \medoo( require_once __DIR__ .'/../../config/database.php' );
        }

    }

}