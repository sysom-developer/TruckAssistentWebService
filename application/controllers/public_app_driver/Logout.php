<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => '',
                ),
            ),
            'body' => array(),
        );
    }
    
    public function index()
    {
        $this->session->unset_userdata($this->appfolder.'_driver_id');

        echo json_en($this->data['error']);
        exit;
    }

}

?>