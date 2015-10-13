<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends Admin_Controller {

	public function index()
	{
		$this->load->view(''.$this->appfolder.'/content_view', $this->data);
	}
}

?>