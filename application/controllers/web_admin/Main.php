<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Admin_Controller {

	public function index()
	{
    	$this->set_path('后台首页');
    	
    	/* 系统信息 */
    	$this->data['ip'] = $_SERVER['SERVER_ADDR'];    // IP地址
    	$this->data['os'] = PHP_OS;    // 服务器操作系统
    	$this->data['web_server'] = $_SERVER['SERVER_SOFTWARE'];    // Web服务器
    	$this->data['php_version'] = PHP_VERSION;    // PHP版本
    	$this->data['mysql_version'] = $this->db->version();    // MySQL版本
    	$this->data['timezone'] = ini_get("date.timezone");    // 时区设置
    	$this->data['gd'] = $this->gd_version();    // GD版本
    	$this->data['max_filesize'] = ini_get('upload_max_filesize');    // 文件上传的最大大小
	    
		$this->load->view(''.$this->appfolder.'/main_view', $this->data);
	}
	
	/**
	 * 
	 * 获取GD版本
	 */
	private function gd_version()
	{
	    $ver_info = gd_info();
        preg_match('/\d/', $ver_info['GD Version'], $match);
        $gd = $match[0];
        
    	if ($gd == 0)
        {
            $gd = 'N/A';
        }
        else
        {
            if ($gd == 1)
            {
                $gd = 'GD1';
            }
            else
            {
                $gd = 'GD2';
            }
    
            $gd .= ' (';
    
            /* 检查系统支持的图片类型 */
            if ($gd && (imagetypes() & IMG_JPG) > 0)
            {
                $gd .= ' JPEG';
            }
    
            if ($gd && (imagetypes() & IMG_GIF) > 0)
            {
                $gd .= ' GIF';
            }
    
            if ($gd && (imagetypes() & IMG_PNG) > 0)
            {
                $gd .= ' PNG';
            }
    
            $gd .= ')';
        }
        
        return $gd;
	}
}

?>