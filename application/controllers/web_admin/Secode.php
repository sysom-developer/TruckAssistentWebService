<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secode extends Admin_Controller {

	public function index()
	{
		$this->load->library('seccode');
		$this->load->helper('random');

		$random = random_number(4);

		// 设置cookie
		$cookie = array(
			'name' => $this->appfolder.'_seccode',
			'value' => do_hash(strtolower($random), 'sha1'),
			'expire' => 0,
			'path' => '/'.$this->appfolder
		);
		$this->input->set_cookie($cookie);

		$this->seccode->code = $random;   // 验证码
		$this->seccode->type = 0;		    // 0英文图片验证码 1中文图片验证码 2Flash 验证码 3语音验证码 4位图验证码
		$this->seccode->width = 100;	    // 验证码宽度
		$this->seccode->height = 30;        // 验证码高度
		$this->seccode->background = 1;		// 是否随机图片背景
		$this->seccode->adulterate = 1;		// 是否随机背景图形
		$this->seccode->ttf = 1;			// 是否随机使用ttf字体
		$this->seccode->angle = 0;			// 是否随机倾斜度
		$this->seccode->warping = 0;		// 是否随机扭曲
		$this->seccode->scatter = 0;		// 是否图片打散
		$this->seccode->color = 1;			// 是否随机颜色
		$this->seccode->size = 0;			// 是否随机大小
		$this->seccode->shadow = 1;			// 是否文字阴影
		$this->seccode->animator = 0;		// 是否GIF 动画
		$this->seccode->fontpath = FCPATH.'static/images/seccode/font/';   // 字体路径
		$this->seccode->datapath = FCPATH.'static/images/seccode/';        // 数据路径

		$this->seccode->display();
	}
}

?>