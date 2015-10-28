<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_conf {
    
    private $CI;
    
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	 * 
	 * 上传图片文件配置参数
	 * @param unknown_type $upload_path	 存储路径
	 */
	public function upload_img_file($upload_path) {
	    $this->folder_exists($upload_path);
	    
	    $config = array();
	    $config['upload_path']   = FCPATH.$upload_path;
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['max_size']      = 10240;
        $config['encrypt_name']  = TRUE;
        
        return $config;
	}
	
	// 检查目录是否存在
	public function folder_exists($upload_path) {
	    $this->recursive_mkdir($upload_path, FCPATH);
	}
	
	// 递归创建目录
    public function recursive_mkdir($upload_path, $before_path, $mode = 0777) {
         $dirs = explode('/' , $upload_path);
         $count = count($dirs);
         for ($i = 0; $i < $count; ++$i) {
             if (empty($dirs[$i])) continue;
             
             $before_path .= $dirs[$i]."/";
             if (!is_dir($before_path) && !mkdir($before_path, $mode)) {
                 continue;
             }
         }
    }
	
}