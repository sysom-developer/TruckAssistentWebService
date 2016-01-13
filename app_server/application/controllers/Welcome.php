<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

//
//		$cond = ['_id' => new \MongoId('5682a0490cd8d80c4374481f')];
//		$conn = \League\Monga::connection('121.40.210.117');
//		$mongo =  $conn->database('calc_output');
//		$data = $mongo->collection('JTA0000102180002')->findOne($cond);
//
//		var_dump($data);

		$result = $this->xingeapp->PushAccountAndroid(2100125550, 'cd847e25372faeb9cfd5d1a54dd5ab61', 'app', '测试', '15050542378');
		var_dump($result);
	}
}
