<?php

namespace comm;

class Message
{
    /**
     * 消息ID
     * @var
     */
    public $_MSG_ID;
    private $_MSG_ID_OFFSET;
    private $_MSG_ID_LENGTH;

    /**
     * 消息数据长度
     * @var
     */
    public $_DATA_SIZE;
    private $_DATA_SIZE_OFFSET;
    private $_DATA_SIZE_LENGTH;

    /**
     * 消息的数据
     * @var
     */
    public $_DATA;
    private $_DATA_OFFSET;
    private $_DATA_FACT_LENGTH;
    private $_DATA_LENGTH;

    /**
     * 校验码
     * @var
     */
    public $_CHECKSUM;
    private $_CHECKSUM_OFFSET;
    private $_CHECKSUM_LENGTH;

    public $_TOTAL_LENGTH;


    function __construct($message_str){

        $this->_MSG_ID_LENGTH = 1 * 2;
        $this->_DATA_SIZE_LENGTH = 2 * 2;
        $this->_CHECKSUM_LENGTH = 2 * 2;





        //定义各个偏移量
        $this->_MSG_ID_OFFSET = 0;

        $this->_DATA_SIZE_OFFSET = $this->_MSG_ID_OFFSET + $this->_MSG_ID_LENGTH;

        $this->_DATA_OFFSET = $this->_DATA_SIZE_OFFSET + $this->_DATA_SIZE_LENGTH;




        // 设置消息id
        $this->_MSG_ID = substr($message_str, $this->_MSG_ID_OFFSET, $this->_MSG_ID_LENGTH);

        //设置消息长度
        $tmp = substr($message_str, $this->_DATA_SIZE_OFFSET, $this->_DATA_SIZE_LENGTH);
        /**
         * 分割成2个数组，每个数组2byte
         */
        $tmp_arr = str_split($tmp, 2);
        $tmp_arr = array_reverse($tmp_arr);
        $tmp = implode('', $tmp_arr);
        $this->_DATA_SIZE = $tmp;
        $data_size = hexdec($this->_DATA_SIZE);

        $buma = $data_size % 8;

        $this->_DATA_FACT_LENGTH = $data_size;
        $this->_DATA_LENGTH = $this->_DATA_FACT_LENGTH + $buma * 2;

        $this->_DATA = substr($message_str, $this->_DATA_OFFSET, $this->_DATA_FACT_LENGTH);


        $this->_CHECKSUM_OFFSET = $this->_DATA_OFFSET + $this->_DATA_LENGTH;
        $this->_CHECKSUM = substr($message_str, $this->_CHECKSUM_OFFSET, $this->_CHECKSUM_LENGTH);


        $this->_TOTAL_LENGTH = $this->_MSG_ID_LENGTH + $this->_DATA_SIZE_LENGTH + $this->_DATA_LENGTH + $this->_CHECKSUM_LENGTH;

    }

    /**
     * 检查校验码
     */
    private function checkout_sum(){

    }

}