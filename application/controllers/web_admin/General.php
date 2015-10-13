<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends Admin_Controller {
    
	public function index()
	{
	    $this->load->helper('greeting');
	    
		$this->load->view(''.$this->appfolder.'/general_view', $this->data);
	}
}

?>