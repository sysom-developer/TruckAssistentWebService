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


    /**
     * 行程概览
     */
    public function detail(){
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
            'save_consumption' => 8,//节省油费
        ];

        $consumption = [
            'estimate_consumption' => 200,//预估油耗
            'average_consumption' => 180,//平均油耗
            'current_consumption' => 210,//当前油耗
        ];

        $economic_speed = [
            'economic_mileage' => 290,//经济里程
            'longest_time' => 40,//最长时间
            'economic_time' => 40,//经济时间
        ];

        $driving_behavior = [
            'sharp_slowdown' => 1, //急减速
            'slow_start' => 3,//起步慢
            'speed_limit' => 0//超速
        ];

        $mileage = [
            'base' => $base,
            'consumption' => $consumption,
            'economic_speed' => $economic_speed,
            'driving_behavior' => $driving_behavior
        ];

        $this->data['error']['body']['waybill'] =  $mileage;

        echo json_en($this->data['error']);
        exit;

    }

    /**
     * 行程详情
     */
    public function tracking(){
        $mileage_id = trim($this->input->get_post('mileage_id', true));
        if (empty($mileage_id) || !is_numeric($mileage_id) ) {
            $this->app_error_func(2198, 'mileage_id 参数错误');
            exit;
        }

        $tracking = [
            ['longitude' => 130, 'latitude' => 65, 'start_time' => 1448575261, 'end_time'=>1448578862],
            ['longitude' => 131, 'latitude' => 66, 'start_time' => 1448575263, 'end_time'=>1448578864],
            ['longitude' => 132, 'latitude' => 67, 'start_time' => 1448575265, 'end_time'=>1448578866],
            ['longitude' => 133, 'latitude' => 68, 'start_time' => 1448575267, 'end_time'=>1448578868],
            ['longitude' => 135, 'latitude' => 69, 'start_time' => 1448575269, 'end_time'=>1448578870],
            ['longitude' => 136, 'latitude' => 70, 'start_time' => 1448575271, 'end_time'=>1448578872],
        ];


        $this->data['error']['body']['tracking'] =  $tracking;

        echo json_en($this->data['error']);
        exit;

    }

    public function speed_ratio(){
        $mileage_id = trim($this->input->get_post('mileage_id', true));
        if (empty($mileage_id) || !is_numeric($mileage_id) ) {
            $this->app_error_func(2298, 'mileage_id 参数错误');
            exit;
        }

        $speed_ratio= [
            ['economic_speed' => '60-80', 'ratio' => 0.75],
            ['high_speed' => '80-', 'ratio' => 0.1],
            ['slow_speed' => '-60', 'ratio' => 0.15],
        ];

        $this->data['error']['body']['tracking'] =  $speed_ratio;

        echo json_en($this->data['error']);
        exit;
    }
}