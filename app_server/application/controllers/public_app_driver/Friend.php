<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friend extends Public_Android_Controller {

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
     * 添加关注
     */
    public function follow()
    {
         $followed_driver_id = trim($this->input->get_post('followed_driver_id', true));
        
        $follower_driver_id = trim($this->input->get_post('follower_driver_id', true));
        $followed_driver_id=1;
        $follower_driver_id=19;
        $this->data['error']['body']=$this->ranking_model->follow($followed_driver_id,$follower_driver_id);
        echo json_en($this->data['error']);
        exit;
    }
    /**
     * 取消关注
     */
    public function unfollow()
    {
         $followed_driver_id = trim($this->input->get_post('followed_driver_id', true));
        
        $follower_driver_id = trim($this->input->get_post('follower_driver_id', true));
        $followed_driver_id=1;
        $follower_driver_id=2;
        $this->ranking_model->unfollow($followed_driver_id,$follower_driver_id);
        echo json_en($this->data['error']);
        exit;
    }

}
