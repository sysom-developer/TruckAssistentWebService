<?php

namespace comm;

class Packet
{
    /**
     * 设备ID
     * @var
     */
    public $_DEV_ID;
    private $_DEV_ID_OFFSET;
    private $_DEV_ID_LENGTH;

    /**
     * 场景ID
     * @var
     */
    public $_FID;
    private $_FID_OFFSET;
    private $_FID_LENGTH;

    /**
     * 时间
     * @var
     */
    public $_TIME;
    private $_TIME_OFFSET;
    private $_TIME_LENGTH;

    /**
     * 协议版本
     * @var
     */
    public $_PROTOCOL_VERSION;
    private $_PROTOCOL_VERSION_OFFSET;
    private $_PROTOCOL_VERSION_LENGTH;

    /**
     * 消息
     * @var
     */
    public $_message_arr;
    private $_MESSAGE;
    private$_MESSAGE_OFFSET;




    function __construct($data)
    {

        $this->_DEV_ID_LENGTH = 16 * 2;
        $this->_FID_LENGTH = 1 * 2;
        $this->_TIME_LENGTH = 4 * 2;
        $this->_PROTOCOL_VERSION_LENGTH = 3 * 2;




        //定义各个偏移量
        $this->_DEV_ID_OFFSET = 0;
        $this->_FID_OFFSET = $this->_DEV_ID_OFFSET + $this->_DEV_ID_LENGTH;
        $this->_TIME_OFFSET = $this->_FID_OFFSET + $this->_FID_LENGTH;
        $this->_PROTOCOL_VERSION_OFFSET = $this->_TIME_OFFSET + $this->_TIME_LENGTH;
        $this->_MESSAGE_OFFSET = $this->_PROTOCOL_VERSION_OFFSET + $this->_PROTOCOL_VERSION_LENGTH;


        $this->_DEV_ID = substr($data, $this->_DEV_ID_OFFSET, $this->_DEV_ID_LENGTH);


//        echo 'fid_start'.PHP_EOL;
        $this->_FID = substr($data, $this->_FID_OFFSET, $this->_FID_LENGTH);
//        var_dump($this->_FID);
//        echo 'fid_end'.PHP_EOL;
        $this->_TIME = substr($data, $this->_TIME_OFFSET, $this->_TIME_LENGTH);

        $this->init_protocol_version($data);

        $this->init_message($data);



    }

    private function init_protocol_version($data)
    {
        /**
         * 获取版本号的数据
         */
        $origin_version = substr($data,$this->_PROTOCOL_VERSION_OFFSET, $this->_PROTOCOL_VERSION_LENGTH);

        /**
         * 分割成3个数组，每个数组2byte
         */
        $origin_version_arr = str_split($origin_version, 2);
        $origin_version_arr = array_slice($origin_version_arr, 0, 2);

        array_walk($origin_version_arr, function(&$v){
            $v = hexdec($v);
        });
        $version = implode('.', $origin_version_arr);

        $this->_PROTOCOL_VERSION = $version;
    }

    private function init_message($data)
    {

        $this->_MESSAGE = substr($data, $this->_MESSAGE_OFFSET);

        $this->_message_arr = new Message_Arr($this->_MESSAGE);
    }



}