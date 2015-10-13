<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends Admin_Controller {
	
    public function index() {
		delete_cookie($this->appfolder, '', '/'.$this->appfolder);
		$this->session->unset_userdata($this->appfolder.'_user_id');
		redirect(''.$this->appfolder.'/login');
	}

}

?>