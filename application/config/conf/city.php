<?php
/**
 * 车辆配置信息
 * Author: andy0010
 * Date: 15/10/19
 * Time: 下午11:11
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// 热门城市
$type = [
    ['city_id'=>'1', 'city_value' => '北京'],
    ['city_id'=>'2', 'city_value' => '上海'],
    ['city_id'=>'3', 'city_value' => '成都'],
    ['city_id'=>'4', 'city_value' => '广州'],
    ['city_id'=>'5', 'city_value' => '长沙'],
    ['city_id'=>'6', 'city_value' => '郑州'],
    ['city_id'=>'7', 'city_value' => '重庆'],
    ['city_id'=>'8', 'city_value' => '苏州'],
    ['city_id'=>'9', 'city_value' => '无锡'],
];


$config['city'] = [
            'hot_city' => $type,

        ];
