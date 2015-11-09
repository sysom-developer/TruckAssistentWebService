<?php


namespace comm;


class FID_ACK
{
    private $_FID_ACK;
    private $_STATE;
    private $_SEP;

    function  __construct($fid, $state){
        $this->_FID_ACK = $fid | 0x80;
        $this->_STATE = $state;
        $this->_SEP = '1c';
    }

    public function get_content(){
        return $this->_FID_ACK. $this->_STATE . $this->_SEP;
    }



}