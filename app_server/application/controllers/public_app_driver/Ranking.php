<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ranking extends Public_Android_Controller {

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
     * 根据条件获取排行榜列表
     */
    public function index()
    {
        $type = trim($this->input->get_post('type', true));

        $result = [];
        if($type == 'driving_mileage'){
            $result = $this->driving_mileage();

        }
        elseif($type == 'consumption_per_100km'){
            $result = $this->consumption_per_100km();
        }

        $self = [
            'driver_id' => 90,
            'name' => 'llldd',
            'driving_mileage' => 4806,
            'consumption_per_100km' => 23,
            'driver_head_icon' => 'xxx',
            'ranking' => 1,
            'nick_name'=>'东风天龙'
        ];

        $this->data['error']['body']['data'] = array_merge($self, $result);

        echo json_en($this->data['error']);
        exit;
    }

    private function driving_mileage(){
        $follow = [
            ['driver_id' => 2, 'name' => 'key', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4806, 'ranking' => 1],
            ['driver_id' => 3, 'name' => '风云', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4702, 'ranking' =>2],
            ['driver_id' => 4, 'name' => '明天更好', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4500, 'ranking' =>3],
            ['driver_id' => 5, 'name' => 'xxx', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4406, 'ranking' => 4],
            ['driver_id' => 6, 'name' => 'aaa', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4399, 'ranking' =>5],
            ['driver_id' => 7, 'name' => '1hd', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4298, 'ranking' =>6],
            ['driver_id' => 8, 'name' => '90jfe', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4100, 'ranking' =>7],
            ['driver_id' => 9, 'name' => 'fulkl', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4000, 'ranking' =>8],
            ['driver_id' => 10, 'name' => 'ffh', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 3807, 'ranking' => 9],
            ['driver_id' => 21, 'name' => 'kldfk', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 3755, 'ranking' =>10],
        ];
        $friend = [
            ['driver_id' => 2, 'name' => 'key', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4806, 'ranking' => 1],
            ['driver_id' => 3, 'name' => '风云', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4702, 'ranking' =>2],
            ['driver_id' => 4, 'name' => '明天更好', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4500, 'ranking' =>3],
            ['driver_id' => 5, 'name' => 'xxx', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4406, 'ranking' =>4],
            ['driver_id' => 6, 'name' => 'aaa', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4399, 'ranking' =>5],
            ['driver_id' => 7, 'name' => '1hd', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4298, 'ranking' =>6],
            ['driver_id' => 8, 'name' => '90jfe', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4100, 'ranking' =>7],
            ['driver_id' => 9, 'name' => 'fulkl', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4000, 'ranking' => 8],
            ['driver_id' => 10, 'name' => 'ffh', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 3807, 'ranking' =>9],
            ['driver_id' => 21, 'name' => 'kldfk', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'driving_mileage' => 3755, 'ranking' => 10],
        ];
        return ['follow' =>$follow, 'friend' => $friend];
    }

    private function consumption_per_100km(){
        $follow = [
            ['driver_id' => 2, 'name' => 'key', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4806, 'ranking' => 1],
            ['driver_id' => 3, 'name' => '风云', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4702, 'ranking' => 2],
            ['driver_id' => 4, 'name' => '明天更好', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4500, 'ranking' => 3],
            ['driver_id' => 5, 'name' => 'xxx', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4406, 'ranking' => 4],
            ['driver_id' => 6, 'name' => 'aaa', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4399, 'ranking' => 5],
            ['driver_id' => 7, 'name' => '1hd', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4298, 'ranking' => 6],
            ['driver_id' => 8, 'name' => '90jfe', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4100, 'ranking' => 7],
            ['driver_id' => 9, 'name' => 'fulkl', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 4000, 'ranking' => 8],
            ['driver_id' => 10, 'name' => 'ffh', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 3807, 'ranking' => 9],
            ['driver_id' => 21, 'name' => 'kldfk', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','driving_mileage' => 3755, 'ranking' => 10],
        ];
        $friend = [
            ['driver_id' => 2, 'name' => 'key', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 34, 'ranking' => 1],
            ['driver_id' => 3, 'name' => '风云', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx', 'consumption_per_100km' => 35, 'ranking' => 2],
            ['driver_id' => 4, 'name' => '明天更好', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 36, 'ranking' => 3],
            ['driver_id' => 5, 'name' => 'xxx', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 37, 'ranking' => 4],
            ['driver_id' => 6, 'name' => 'aaa', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 38, 'ranking' => 5],
            ['driver_id' => 7, 'name' => '1hd', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 39, 'ranking' => 6],
            ['driver_id' => 8, 'name' => '90jfe', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 45, 'ranking' => 7],
            ['driver_id' => 9, 'name' => 'fulkl', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 47, 'ranking' => 8],
            ['driver_id' => 10, 'name' => 'ffh', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 48, 'ranking' => 9],
            ['driver_id' => 21, 'name' => 'kldfk', 'nick_name'=>'东风天龙', 'driver_head_icon' => 'xxx','consumption_per_100km' => 58, 'ranking' => 10],
        ];
        return ['follow' =>$follow, 'friend' => $friend];
    }

    public function detail(){

        $type = trim($this->input->get_post('type', true));;

        $result = [];
        if($type == 'driving_mileage'){
            $result = [ 'driving_mileage' => [
                ['month' => 1, 'mileage' => 23],
                ['month' => 2, 'mileage' => 28],
                ['month' => 3, 'mileage' => 29],
                ['month' => 4, 'mileage' => 22],
                ['month' => 5, 'mileage' => 23],
                ['month' => 6, 'mileage' => 25],
            ]];

        } elseif($type == 'consumption_per_100km'){
            $result = [ 'consumption_per_100km' => [
                ['month' => 1, 'consumption' => 23],
                ['month' => 2, 'consumption' => 28],
                ['month' => 3, 'consumption' => 29],
                ['month' => 4, 'consumption' => 22],
                ['month' => 5, 'consumption' => 23],
                ['month' => 6, 'consumption' => 25],
            ]];
        }

        $self = ['base' => [
            'driver_id' => 90,
            'name' => 'llldd',
            'driving_mileage' => 4806,
            'consumption_per_100km' => 23,
            'driver_head_icon' => 'xxx',
            'nick_name'=>'东风天龙',
        ]];

        $this->data['error']['body']['data'] = array_merge($self, $result);

        echo json_en($this->data['error']);
        exit;
    }
}
