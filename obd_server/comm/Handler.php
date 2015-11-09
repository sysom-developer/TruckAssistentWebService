<?php

namespace comm;

use comm\FID_ACK;
use comm\Packet;
use comm\Byte;

class Handler {
    public static function exe($data)
    {
        global $error_code, $command_table;

        if($data == $error_code['SEP']){
            return 'SEP';
        }

        $packet = new Packet($data);
        $dev_id = Byte::Hex2String($packet->_DEV_ID);
        $fid = '0x'.$packet->_FID;
        $time = hexdec($packet->_TIME);
        $version = $packet->_PROTOCOL_VERSION;

        $result = self::message_handler($packet);

        return $result;
    }

    static function message_handler($packet)
    {
        global $error_code, $command_table;
        array_walk($packet->_message_arr, function($message) use ($packet, $error_code, $command_table){
//            $fun_code = $error_code['MSG_ID'][$message->_MSG_ID];
//            var_dump($message->_MSG_ID);
            $fun_code = 'OTA_UPDATE_QUERY';
            $fun = $command_table[$fun_code];
            $fun($packet, $message);
        });

        $state = $error_code['STATE']['STATE_RECV_OK'];
        $fid_ack = new FID_ACK($packet->_FID, $state);
        return $fid_ack->get_content();
    }
}