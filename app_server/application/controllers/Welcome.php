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


		$cond = ['_id' => new \MongoId('5682a0490cd8d80c4374481f')];
		$conn = \League\Monga::connection('121.40.210.117');
		$mongo =  $conn->database('calc_output');
		$data = $mongo->collection('JTA0000102180002')->findOne($cond);

		var_dump($data);

//		$result = $this->xingeapp->PushAccountAndroid(2100125550, 'cd847e25372faeb9cfd5d1a54dd5ab61', 'app', '测试', '15050542378');
//		var_dump($result);
	}

	/**
	 * 生成运单
	 */
	public function genwaybill(){
		$data = [
			['device_id' => 'JTA0000102130002', 'id'=> '56a7710c0cd8d871ded89dc2'],
			['device_id' => 'JTA0000102160002', 'id'=> '56a7697b0cd8d85d33fa9fd6'],
			['device_id' => 'JTA0000102170002', 'id'=> '56a641b90cd8d82f0832c334'],
			['device_id' => 'JTA0000102180002', 'id'=> '56a63b840cd8d8188a10b654'],
			['device_id' => 'JTA0000102190002', 'id'=> '56a6bd3b0cd8d837a7c29061'],
			['device_id' => 'JTA0000108770002', 'id'=> '56a77cbb0cd8d87de6437ac4'],
		];


		$f = function ($v){
			$device_id = $v['device_id'];
			$id = $v['id'];

			$conn = \League\Monga::connection('121.40.210.117');
			$calc_output_mongo =  $conn->database('calc_output');

			$cond = ['_id' => new \MongoId($id)];
			$data = $calc_output_mongo->collection($device_id.'_waybill')->findOne($cond);

			$start_city = $data['start_city'];
			$start_poi_arr = $start_city['start_poi'];
			$start_city_name_arr = $start_city['start_city_name'];
			$start_time_arr = $start_city['start_time'];
			$end_poi_arr = $start_city['end_poi'];

			$end_city = $data['end_city'];
			$start_poi_arr = $end_city['start_poi'];
			$start_city_name_arr = $end_city['end_city_name'];
			$start_time_arr = $end_city['end_time'];
			$end_poi_arr = $end_city['end_poi'];


			$waybill_mongo =  $conn->database('waybill');
			foreach($start_city['start_poi'] as $k => $v){
				$waybill = [
					'device_id'  => $device_id,

					'start_city_name' => $start_city['start_city_name'][$k],
					'start_time' => $start_city['start_time'][$k],
					'start_city_start_poi' => $start_city['start_poi'][$k],
					'start_city_end_poi' => $start_city['end_poi'][$k],

					'end_city_name' => $end_city['end_city_name'][$k],
					'end_city_start_poi' => $end_city['start_poi'][$k],
					'end_city_end_poi' => $end_city['end_poi'][$k],
					'end_time'  => $end_city['end_time'][$k]
				];

				$waybill_mongo->collection('waybill')->insert($waybill);
			}

		};

//		array_walk($data, $f);

	}

	public function find_waybill(){
		$cond = ['start_time' => 1453329893];
		$conn = \League\Monga::connection('121.40.210.117');
		$waybill_mongo =  $conn->database('waybill');
		$data = $waybill_mongo->collection('waybill')->findOne($cond);

		var_dump($data);
	}

	public function find_waybill_by_id(){
		$cond = ['_id' => new \MongoId('56a7692c0cd8d84997492618')];
		$conn = \League\Monga::connection('121.40.210.117');
		$waybill_mongo =  $conn->database('calc_output');
		$data = $waybill_mongo->collection('JTA0000102160002')->findOne($cond);
		var_dump($data['vehicle_driving_section']['end_time']);

	}

	public function gen_tmp_mileage(){
		$device_id = 'JTA0000102160002';
		$id = '56a769310cd8d8499749261d';

		$cond = ['_id' => new \MongoId($id)];
		$conn = \League\Monga::connection('121.40.210.117');
		$calc_output_mongo =  $conn->database('calc_output');
		$data = $calc_output_mongo->collection($device_id)->findOne($cond);

		$s = $data['vehicle_driving_section']['start_time']['0'];
		$vehicle_driving_section = $data['vehicle_driving_section'];

		foreach($vehicle_driving_section['time_interval'] as $k => $v){
			$mileage_tmp = [
				'device_id' => $device_id,
				'time_interval' => $vehicle_driving_section['time_interval'][$k],
				'ave_speed' => $vehicle_driving_section['ave_speed'][$k],
				'first_point' => $vehicle_driving_section['first_point'][$k],
				'100km_fuel_consumption' => $vehicle_driving_section['100km_fuel_consumption'][$k],
				'end_time' => $this->get_mongo_data($vehicle_driving_section['end_time'][$k]),
				'end_poi' => $vehicle_driving_section['end_poi'][$k],
				'last_point' => $vehicle_driving_section['last_point'][$k],
				'start_poi' => $vehicle_driving_section['start_poi'][$k],
				'start_time' => $this->get_mongo_data($vehicle_driving_section['start_time'][$k]),
				'distance' => $vehicle_driving_section['distance'][$k],
				'fuel_quantity' => $vehicle_driving_section['fuel_quantity'][$k],
				'distance' => $vehicle_driving_section['distance'][$k],
				'distance' => $vehicle_driving_section['distance'][$k],
				'distance' => $vehicle_driving_section['distance'][$k],
				'distance' => $vehicle_driving_section['distance'][$k],
			];
		}



	}

	private function get_mongo_data($o){
		return $o->bin;
	}

}
