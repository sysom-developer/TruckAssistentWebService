<?php

namespace comm\Protocol;

class Response_Message
{
    /**
     * 消息ID
     * @var
     */
    private   $_MSG_ID;


    /**
     * 消息数据长度
     * @var
     */
    private $_LENGTH;

    /**
     * 消息的数据
     * @var
     */
    private $_DATA;

    /**
     * 校验码
     * @var
     */
    private $_CHECKSUM;

    private $_SEP;



    function __construct($meg_id, $data){
        $this->_MSG_ID = $meg_id;
        $this->_LENGTH = [0x01,0x00];
        $this->_DATA = [$data, 0x55,0x55,0x55,0x55,0x55,0x55,0x55];
        $this->_CHECKSUM = [0x55, 0x00];
        $this->_SEP = 0x1c;

    }

    public  function  getResponse(){

        $result =  chr($this->_MSG_ID). chr($this->_LENGTH[0]). chr($this->_LENGTH[1]).

            $this->get_data().
            $this->get_check_sum()
            .chr($this->_SEP);
        file_put_contents(0x01, $result);
        return $result;
    }

    function get_data(){
        $data = '';
        array_walk($this->_DATA, function($v) use (&$data){
            $data .= chr($v);
        });
        return $data;
    }

    function get_check_sum(){
        $data_sum = 0;
        array_walk($this->_DATA, function($v) use (&$data_sum){
            $data_sum += $v;
        });
        $lbs = $data_sum/16;
        $mbs = $data_sum%16;
        return chr($lbs) . chr($mbs);
    }


//        echo "data_size:";
//        var_dump($data_size);
//        echo PHP_EOL;
//        $buma = 0;
//        if($data_size % 8 > 0){
//            $buma = 8 - $data_size % 8;
//        }

//        $this->_DATA_FACT_LENGTH = $data_size * 2;
//        $this->_DATA_LENGTH = $this->_DATA_FACT_LENGTH + $buma * 2;
//echo 'data_size: ' .$data_size. PHP_EOL;
//        echo 'buma:' .$buma;
//        echo PHP_EOL;


//        $this->_DATA = substr($message_str, $this->_DATA_OFFSET, $this->_DATA_FACT_LENGTH);

//        echo "data_end:";
//        var_dump($this->_DATA);
//        echo PHP_EOL;
//
//        $this->_CHECKSUM_OFFSET = $this->_DATA_OFFSET + $this->_DATA_LENGTH;
//        $tmp = substr($message_str, $this->_CHECKSUM_OFFSET, $this->_CHECKSUM_LENGTH);
//        $tmp_arr = str_split($tmp, 2);
//        $tmp_arr = array_reverse($tmp_arr);
//        $tmp = implode('', $tmp_arr);
//        $this->_CHECKSUM = $tmp;


//        $this->_TOTAL_LENGTH = $this->_MSG_ID_LENGTH + $this->_DATA_SIZE_LENGTH + $this->_DATA_LENGTH + $this->_CHECKSUM_LENGTH;
//        echo "total_length:";
//        var_dump($this->_TOTAL_LENGTH);
//        echo PHP_EOL;
//        $this->check_sum($message_str);



}