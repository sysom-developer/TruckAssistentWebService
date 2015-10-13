<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Admin_Controller {
    
    public function __construct() 
    {
        parent::__construct();
    }

	public function index()
	{
		$this->load->view(''.$this->appfolder.'/login_view', $this->data);
	}
	
	public function act_login()
	{
	    $username = htmlspecialchars($this->input->post('username', TRUE));
	    $password = do_hash($this->input->post('password', TRUE), 'sha1');
	    $seccodeverify = htmlspecialchars($this->input->post('seccodeverify', TRUE));
	    $cookie_seccode = get_cookie($this->appfolder.'_seccode');
	    
	    // 检查用户名和密码
	    if (empty($username) || empty($password)) {
			show_error('用户名和密码不可以为空，请重新操作，<a href="'.site_url(''.$this->appfolder.'/login').'">返回</a>', 500, '系统提示');
	    }
	    
	    // 检查验证码是否输入正确
	    if (do_hash(strtolower($seccodeverify), 'sha1') != $cookie_seccode) {
	        show_error('验证码输入错误，请重新操作，<a href="'.site_url(''.$this->appfolder.'/login').'">返回</a>', 500, '系统提示');
	    }

		$where = array(
		    'username' => $username,
		    'password' => $password,
		);
		$user_info = $this->common_model->get_data('admin', $where)->row_array();
		
		// 用户名或密码错误
		if (!$user_info) {
			show_error('用户名或密码错误，请重新操作，<a href="'.site_url(''.$this->appfolder.'/login').'">返回</a>', 500, '系统提示');
		}
		
		// 加密字符串
		$encode_string = 'yadgen|' . $username . '|' . $password;
		$encrypted_string = $this->encrypt->encode($encode_string);

		// 设置cookie
		$cookie = array(
			'name' => $this->appfolder,
			'value' => $encrypted_string,
			'expire' => 0,
			'path' => '/'.$this->appfolder,
		);
		$this->input->set_cookie($cookie);

		// 设置session
		$session_data = array(
		    $this->appfolder.'_user_id' => $user_info['id'],
		);
		$this->session->set_userdata($session_data);

		// 删除验证码cookie
		delete_cookie($this->appfolder.'_seccode', '', '/'.$this->appfolder);

		redirect(''.$this->appfolder.'/general');
	}
}

?>
