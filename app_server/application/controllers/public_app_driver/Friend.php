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
     * 根据条件获取排行榜列表
     */
    public function follow()
    {

        echo json_en($this->data['error']);
        exit;
    }


}
