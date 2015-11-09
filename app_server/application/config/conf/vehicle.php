<?php
/**
 * 车辆配置信息
 * Author: andy0010
 * Date: 15/10/19
 * Time: 下午11:11
 */

defined('BASEPATH') OR exit('No direct script access allowed');

//车辆类型
$type = [
    ['vehicle_type_id'=>'1', 'vehicle_type_value' => '平板车'],
    ['vehicle_type_id'=>'2', 'vehicle_type_value' => '厢式车'],
    ['vehicle_type_id'=>'3', 'vehicle_type_value' => '爬梯车'],
    ['vehicle_type_id'=>'4', 'vehicle_type_value' => '兰板车'],
    ['vehicle_type_id'=>'5', 'vehicle_type_value' => '自卸车'],
    ['vehicle_type_id'=>'6', 'vehicle_type_value' => '高拦车'],
    ['vehicle_type_id'=>'7', 'vehicle_type_value' => '飞翼车'],
    ['vehicle_type_id'=>'8', 'vehicle_type_value' => '面包车'],
    ['vehicle_type_id'=>'9', 'vehicle_type_value' => '集装箱'],
    ['vehicle_type_id'=>'10', 'vehicle_type_value' => '商品车'],
    ['vehicle_type_id'=>'11', 'vehicle_type_value' => '保温车'],
    ['vehicle_type_id'=>'12', 'vehicle_type_value' => '冷藏车'],
    ['vehicle_type_id'=>'13', 'vehicle_type_value' => '罐车'],
];

//车辆载重
$load = [
    ['vehicle_load_id'=>'1', 'vehicle_load_value' => '4.2'],
    ['vehicle_load_id'=>'2', 'vehicle_load_value' => '5.2'],
    ['vehicle_load_id'=>'3', 'vehicle_load_value' => '5.8'],
    ['vehicle_load_id'=>'4', 'vehicle_load_value' => '6.2'],
    ['vehicle_load_id'=>'5', 'vehicle_load_value' => '6.5'],
    ['vehicle_load_id'=>'6', 'vehicle_load_value' => '6.8'],
    ['vehicle_load_id'=>'7', 'vehicle_load_value' => '8.0'],
    ['vehicle_load_id'=>'8', 'vehicle_load_value' => '9.6'],
    ['vehicle_load_id'=>'9', 'vehicle_load_value' => '12'],
    ['vehicle_load_id'=>'10', 'vehicle_load_value' => '13'],
    ['vehicle_load_id'=>'11', 'vehicle_load_value' => '13.5'],
    ['vehicle_load_id'=>'12', 'vehicle_load_value' => '15'],
    ['vehicle_load_id'=>'13', 'vehicle_load_value' => '16.5'],
    ['vehicle_load_id'=>'14', 'vehicle_load_value' => '17.5'],
    ['vehicle_load_id'=>'15', 'vehicle_load_value' => '18.5'],
    ['vehicle_load_id'=>'16', 'vehicle_load_value' => '20'],
    ['vehicle_load_id'=>'17', 'vehicle_load_value' => '22'],
    ['vehicle_load_id'=>'18', 'vehicle_load_value' => '24'],
];

//车辆长度
$length = [
    ['vehicle_length_id'=>'1', 'vehicle_length_value' => '4.2'],
    ['vehicle_length_id'=>'2', 'vehicle_length_value' => '5.2'],
    ['vehicle_length_id'=>'3', 'vehicle_length_value' => '5.8'],
    ['vehicle_length_id'=>'4', 'vehicle_length_value' => '6.2'],
    ['vehicle_length_id'=>'5', 'vehicle_length_value' => '6.5'],
    ['vehicle_length_id'=>'6', 'vehicle_length_value' => '6.8'],
    ['vehicle_length_id'=>'7', 'vehicle_length_value' => '8.0'],
    ['vehicle_length_id'=>'8', 'vehicle_length_value' => '9.6'],
    ['vehicle_length_id'=>'9', 'vehicle_length_value' => '12'],
    ['vehicle_length_id'=>'10', 'vehicle_length_value' => '13'],
    ['vehicle_length_id'=>'11', 'vehicle_length_value' => '13.5'],
    ['vehicle_length_id'=>'12', 'vehicle_length_value' => '15'],
    ['vehicle_length_id'=>'13', 'vehicle_length_value' => '16.5'],
    ['vehicle_length_id'=>'14', 'vehicle_length_value' => '17.5'],
    ['vehicle_length_id'=>'15', 'vehicle_length_value' => '18.5'],
    ['vehicle_length_id'=>'16', 'vehicle_length_value' => '20'],
    ['vehicle_length_id'=>'17', 'vehicle_length_value' => '22'],
    ['vehicle_length_id'=>'18', 'vehicle_length_value' => '24'],
];

$rear_axle_ratio = [
    ['rear_axle_ratio_id'=>'1', 'rear_axle_ratio_value' => '4.2'],
    ['rear_axle_ratio_id'=>'2', 'rear_axle_ratio_value' => '4.3'],
    ['rear_axle_ratio_id'=>'3', 'rear_axle_ratio_value' => '4.4'],
    ['rear_axle_ratio_id'=>'4', 'rear_axle_ratio_value' => '4.5'],
    ['rear_axle_ratio_id'=>'5', 'rear_axle_ratio_value' => '4.6'],
    ['rear_axle_ratio_id'=>'6', 'rear_axle_ratio_value' => '4.3'],
    ['rear_axle_ratio_id'=>'7', 'rear_axle_ratio_value' => '4.4'],
];
$config['vehicle'] = [
            'type' => $type,
            'load'=> $load,
            'length' => $length,
            'rear_axle_ratio' => $rear_axle_ratio,
        ];
