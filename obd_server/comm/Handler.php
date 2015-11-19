<?php

namespace comm;

use comm\FID_ACK;
use comm\Packet;
use comm\Byte;

class Handler {
    public static function exe($data, $data_file_name)
    {
        global $error_code;
        $data = Byte::String2Hex($data);

        if($data == $error_code['SEP']){
            return false;
        }
        if(strlen($data) == 6){
            return false;
        }

        $packet = new Packet($data);

        $echo_header = self::echo_packet_header($packet);
        $echo_messages = self::echo_packet_messages($packet);


        $unpack_data = $echo_header.$echo_messages;
        file_put_contents($data_file_name, $unpack_data);

        $result = self::message_handler($packet, $data_file_name);

        return $result;
    }

    static function message_handler($packet, $data_file_name)
    {
        global $error_code, $command_table;

        $result_set = [];

        if(is_array($packet->_message_arr->arr)){
            array_walk($packet->_message_arr->arr, function($message) use ($packet, $error_code, $command_table, &$result_set, $data_file_name){
                $fun_code = $error_code['MSG_ID'][$message->_MSG_ID];
                $fun = $command_table[$fun_code];
                $fun_result = $fun($packet, $message, $data_file_name);
                $result_set[] = $fun_result;
            });
        }

        $state = $error_code['STATE']['STATE_RECV_OK'];
        $fid_ack = new FID_ACK($packet->_FID, $state);
        $ack = $fid_ack->get_bytes();
        $result_set[] = $ack;

        return $result_set;


    }

    static function echo_packet_header($packet){
        $dev_id = Byte::Hex2String($packet->_DEV_ID);
        $fid = '0x'.$packet->_FID;
        $time = hexdec($packet->_TIME);
        $version = $packet->_PROTOCOL_VERSION;

        $echo_header = 'header'. "\n";
        $echo_header .= "    dev_id: " . $dev_id . "\n";
        $echo_header .= "    fid: " . $fid . "\n";
        $echo_header .= "    time:" . $time . "\n";
        $echo_header .= "    version:" . $version . "\n";
        $echo_header .= "\n";

        echo 'header'. "\n";
        echo "    dev_id: " . $dev_id . "\n";
        echo "    fid: " . $fid . "\n";
        echo "    time:" . $time . "\n";
        echo "    version:" . $version . "\n";
        echo "\n";

        return $echo_header;

    }

    static function echo_packet_messages($packet){
        $message_arr = $packet->_message_arr->arr;
        $i = 0;
        $echo_messages = '';
        if(is_array($message_arr)){
            array_walk($message_arr, function($message) use (&$i, &$echo_messages){
                $i++;

                $msg_id = '0x' .$message->_MSG_ID;
                $data_size = $message->_DATA_SIZE;
                $data = $message->_DATA;
                $checksum = $message->_CHECKSUM;
                echo 'message' . $i . ':'. "\n";
                echo '    MSG_ID:' . $msg_id. "\n";
                echo '    DATA_SIZE:' . $data_size. "\n";
                echo '    DATA:' . $data. "\n";
                echo '    CHECKSUM:' . $checksum. "\n";
                echo "\n";


                $echo_messages .= 'message' . $i . ':'. "\n";
                $echo_messages .= '    MSG_ID:' . $msg_id. "\n";
                $echo_messages .= '    DATA_SIZE:' . $data_size. "\n";
                $echo_messages .= '    DATA:' . $data. "\n";
                $echo_messages .= '    CHECKSUM:' . $checksum. "\n";
                $echo_messages .= "\n";
            });
            return $echo_messages;
        }

        return "not message".PHP_EOL;


    }
}