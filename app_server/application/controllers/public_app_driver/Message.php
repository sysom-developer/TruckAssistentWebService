<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => 'success',
                ),
            ),
            'body' => array(),
        );
    }

    /**
     * 根据司机id获取消息
     */
    public function index()
    {
        $driver_id = trim($this->input->get_post('type', true));

        $data = [
            ['id' => 1, 'type' => 1, 'contents' => 'xxxxx,xxcfd,xxxx', 'create_time' => time()],
            ['id' => 1, 'type' => 2, 'contents' => 'xxxxx,xxcfd,xxxx', 'create_time' => time()],
            ['id' => 1, 'type' => 3, 'contents' => 'xxxxx,xxcfd,xxxx', 'create_time' => time()],
            ['id' => 1, 'type' => 4, 'contents' => 'xxxxx,xxcfd,xxxx', 'create_time' => time()],
            ['id' => 1, 'type' => 5, 'contents' => 'xxxxx,xxcfd,xxxx', 'create_time' => time()],
            ['id' => 1, 'type' => 6, 'contents' => 'xxxxx,xxcfd,xxxx', 'create_time' => time()],

        ];

        $this->data['error']['body']['data'] = $data;

        echo json_en($this->data['error']);
        exit;
    }

    /**
     *
     */
    public function detail()
    {
        $message_id = trim($this->input->get_post('message_id', true));;

        $data = [
            'id' => 1, 'type' => 1, 'contents' => 'xxxxx,xxcfd,xxxx', 'create_time' => time()

        ];

        $this->data['error']['body']['data'] = $data;

        echo json_en($this->data['error']);
        exit;
    }

    public function del()
    {
        echo json_en($this->data['error']);
        exit;
    }

    /**
     * 获取推送新消息
     */
    public function pull_message(){
        $driver_id = trim($this->input->get_post('type', true));

        $data = [
            'id' => 1, 'type' => 1, 'contents' => 'xxxxx,xxcfd,xxxx'
        ];

        $this->data['error']['body']['data'] = $data;

        echo json_en($this->data['error']);
        exit;
    }

}
