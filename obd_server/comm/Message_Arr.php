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
//        echo "message:";
//        var_dump($message_str);
        echo PHP_EOL;
        for(;$message_str != false;){
//            var_dump($message_str);
            $message = new Message($message_str);
            $this->arr[] = $message;
            $message_str = substr($message_str, $message->_TOTAL_LENGTH + 2);
        }

    }
}