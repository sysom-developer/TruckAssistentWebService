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
    ['1' => '平板车'],
    ['2' => '厢式车'],
    ['3' => '爬梯车'],
    ['4' => '兰板车'],
    ['5' => '自卸车'],
    ['6' => '高拦车'],
    ['7' => '飞翼车'],
    ['8' => '面包车'],
    ['9' => '集装箱'],
    ['10' => '商品车'],
    ['11' => '保温车'],
    ['12' => '冷藏车'],
    ['13' => '罐车'],
];

//车辆载重
$load = [
    ['1' => '4.2吨'],
    ['2' => '5.2吨'],
    ['3' => '5.8吨'],
    ['4' => '6.2吨'],
    ['5' => '6.5吨'],
    ['6' => '6.8吨'],
    ['7' => '8.0吨'],
    ['8' => '9.6吨'],
    ['9' => '12吨'],
    ['10' => '13吨'],
    ['11' => '13.5吨'],
    ['12' => '15吨'],
    ['13' => '16.5吨'],
    ['14' => '17.5吨'],
    ['15' => '18.5吨'],
    ['16' => '20吨'],
    ['17' => '22吨'],
    ['18' => '24吨'],
];

//车辆长度
$length = [
    ['1' => '4.2米'],
    ['2' => '5.2米'],
    ['3' => '5.8米'],
    ['4' => '6.2米'],
    ['5' => '6.5米'],
    ['6' => '6.8米'],
    ['7' => '8.0米'],
    ['8' => '9.6米'],
    ['9' => '12米'],
    ['10' => '13米'],
    ['11' => '13.5米'],
    ['12' => '15米'],
    ['13' => '16.5米'],
    ['14' => '17.5米'],
    ['15' => '18.5米'],
    ['16' => '20米'],
    ['17' => '22米'],
    ['18' => '24米'],
];


$config['vehicle'] = [
            'type' => $type,
            'load'=> $load,
            'length' => $length
        ];
