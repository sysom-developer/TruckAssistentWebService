<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {
    
    public function index() {
        delete_cookie($this->appfolder.'_shipper', '', '/'.$this->appfolder);
        $this->session->unset_userdata($this->appfolder.'_shipper_id');
        redirect(''.$this->appfolder.'/login');
    }

}

?>