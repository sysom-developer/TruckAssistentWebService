<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mileage extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => 'success',
                ),
            ),
            'body' => array(),
        );
    }

    public function index(){
        $mileage_id = trim($this->input->get_post('mileage_id', true));

        if (empty($mileage_id) || !is_numeric($mileage_id) ) {
            $this->app_error_func(2099, 'mileage_id 参数错误');
            exit;
        }

        $base = [
            'mileage_id' => 2,
            'name' => '2bx服务区',
            'start_time' => 1448575261,
            'end_time'=>1448578861,

            'driving_mileage' => 480,//行驶里程
            'average_velocity' => 66.8,//平均速度
            'driving_time'  => 5,//驾驶时间
            'average_consumption' => 37,//平均油耗
        ];


        $speed_ratio= [
            ['economic_speed' => '60-80', 'ratio' => 0.75],
            ['high_speed' => '80-', 'ratio' => 0.1],
            ['slow_speed' => '-60', 'ratio' => 0.15],
        ];

        $tracking = [
            ['longitude' => 130, 'latitude' => 65, 'start_time' => 1448575261, 'end_time'=>1448578862],
            ['longitude' => 131, 'latitude' => 66, 'start_time' => 1448575263, 'end_time'=>1448578864],
            ['longitude' => 132, 'latitude' => 67, 'start_time' => 1448575265, 'end_time'=>1448578866],
            ['longitude' => 133, 'latitude' => 68, 'start_time' => 1448575267, 'end_time'=>1448578868],
            ['longitude' => 135, 'latitude' => 69, 'start_time' => 1448575269, 'end_time'=>1448578870],
            ['longitude' => 136, 'latitude' => 70, 'start_time' => 1448575271, 'end_time'=>1448578872],
        ];

        $mileage = [
            'base' => $base,
            'speed_ratio' => $speed_ratio,
            'tracking' => $tracking
        ];

        $this->data['error']['body']['mileage'] =  $mileage;

        echo json_en($this->data['error']);
        exit;

    }

}