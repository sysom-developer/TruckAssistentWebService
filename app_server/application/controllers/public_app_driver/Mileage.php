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
            ['longitude' => 121.604924, 'ew_indicator' => '45', 'latitude' => 31.282053, 'ns_indicator' => '4e', 'time' => 1448600020],
            ['longitude' => 121.605203, 'ew_indicator' => '45', 'latitude' => 31.281904, 'ns_indicator' => '4e', 'time' => 1448601722],
            ['longitude' => 114.7689,   'ew_indicator' => '45', 'latitude' => 32.280327, 'ns_indicator' => '4e', 'time' => 1449107905],
            ['longitude' => 105.270138, 'ew_indicator' => '45', 'latitude' => 32.149730, 'ns_indicator' => '4e', 'time' => 1449194171],
            ['longitude' => 105.121904, 'ew_indicator' => '45', 'latitude' => 32.17897,  'ns_indicator' => '4e', 'time' => 1449195250],
            ['longitude' => 105.9234,   'ew_indicator' => '45', 'latitude' => 31.888799, 'ns_indicator' => '4e', 'time' => 1449196048],
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