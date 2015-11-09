<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 业务逻辑层，负责业务模块的逻辑应用设计.
 * controller中调用service的接口实现业务逻辑处理.
 * 提高了通用的业务逻辑的复用性.
 * 涉及到具体业务调用Model的接口.
 */
class Service {

    public function __construct() {
        log_message('debug', "Service Class Initialized");
    }

    function __get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

}