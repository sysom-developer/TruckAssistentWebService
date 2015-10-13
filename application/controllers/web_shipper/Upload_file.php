<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_file extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        
        header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
    }
	
	public function index() {
        $file_id = $this->input->get('file_id');

        $save_dir = $file_id;
	    $upload_data = upload_img_file($file_id, $save_dir);

        if ($upload_data['status'] != -1) {
            $filepath = substr($upload_data['data']['file_path'], stripos($upload_data['data']['file_path'], "data_tmp"));
            $data = array(
                'filetype' => $upload_data['data']['file_type'],
                'filename' => $upload_data['data']['file_name'],
                'filesize' => $upload_data['data']['file_size'],
                'filepath' => $filepath,
            );
            $upload_data['data']['attachment_id'] = $this->common_model->insert('attachment_tmp', $data);
        }

        echo json_encode($upload_data);
        exit;
	}

}

?>