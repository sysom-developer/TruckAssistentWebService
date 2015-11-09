<?php
/**
 * Created by PhpStorm.
 * User: chenqiuyu
 * Date: 15/11/8
 * Time: 下午4:33
 */

namespace comm;


class Message_Arr
{

    public $arr;

    function __construct($message_str){

        for(;$message_str != false;){
            $message = new Message($message_str);
            $this->arr[] = $message;
            $message_str = substr($message_str, $message->_TOTAL_LENGTH + 2);
        }

    }
}