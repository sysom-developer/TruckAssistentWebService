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
        $type = trim($this->input->get_post('type', true));;

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
        ];

        $this->data['error']['body']['data'] = array_merge($self, $result);

        echo json_en($this->data['error']);
        exit;
    }

    private function driving_mileage(){
        $follow = [
            ['driver_id' => 2, 'name' => 'key', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4806],
            ['driver_id' => 3, 'name' => '风云', 'driver_head_icon' => 'xxx','driving_mileage' => 4702],
            ['driver_id' => 4, 'name' => '明天更好', 'driver_head_icon' => 'xxx','driving_mileage' => 4500],
            ['driver_id' => 5, 'name' => 'xxx', 'driver_head_icon' => 'xxx','driving_mileage' => 4406],
            ['driver_id' => 6, 'name' => 'aaa', 'driver_head_icon' => 'xxx','driving_mileage' => 4399],
            ['driver_id' => 7, 'name' => '1hd', 'driver_head_icon' => 'xxx','driving_mileage' => 4298],
            ['driver_id' => 8, 'name' => '90jfe', 'driver_head_icon' => 'xxx','driving_mileage' => 4100],
            ['driver_id' => 9, 'name' => 'fulkl', 'driver_head_icon' => 'xxx','driving_mileage' => 4000],
            ['driver_id' => 10, 'name' => 'ffh', 'driver_head_icon' => 'xxx','driving_mileage' => 3807],
            ['driver_id' => 21, 'name' => 'kldfk', 'driver_head_icon' => 'xxx','driving_mileage' => 3755],
        ];
        $friend = [
            ['driver_id' => 2, 'name' => 'key', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4806],
            ['driver_id' => 3, 'name' => '风云', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4702],
            ['driver_id' => 4, 'name' => '明天更好', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4500],
            ['driver_id' => 5, 'name' => 'xxx', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4406],
            ['driver_id' => 6, 'name' => 'aaa', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4399],
            ['driver_id' => 7, 'name' => '1hd', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4298],
            ['driver_id' => 8, 'name' => '90jfe', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4100],
            ['driver_id' => 9, 'name' => 'fulkl', 'driver_head_icon' => 'xxx', 'driving_mileage' => 4000],
            ['driver_id' => 10, 'name' => 'ffh', 'driver_head_icon' => 'xxx', 'driving_mileage' => 3807],
            ['driver_id' => 21, 'name' => 'kldfk', 'driver_head_icon' => 'xxx', 'driving_mileage' => 3755],
        ];
        return ['follow' =>$follow, 'friend' => $friend];
    }

    private function consumption_per_100km(){
        $follow = [
            ['driver_id' => 2, 'name' => 'key', 'driver_head_icon' => 'xxx','driving_mileage' => 4806],
            ['driver_id' => 3, 'name' => '风云', 'driver_head_icon' => 'xxx','driving_mileage' => 4702],
            ['driver_id' => 4, 'name' => '明天更好', 'driver_head_icon' => 'xxx','driving_mileage' => 4500],
            ['driver_id' => 5, 'name' => 'xxx', 'driver_head_icon' => 'xxx','driving_mileage' => 4406],
            ['driver_id' => 6, 'name' => 'aaa', 'driver_head_icon' => 'xxx','driving_mileage' => 4399],
            ['driver_id' => 7, 'name' => '1hd', 'driver_head_icon' => 'xxx','driving_mileage' => 4298],
            ['driver_id' => 8, 'name' => '90jfe', 'driver_head_icon' => 'xxx','driving_mileage' => 4100],
            ['driver_id' => 9, 'name' => 'fulkl', 'driver_head_icon' => 'xxx','driving_mileage' => 4000],
            ['driver_id' => 10, 'name' => 'ffh', 'driver_head_icon' => 'xxx','driving_mileage' => 3807],
            ['driver_id' => 21, 'name' => 'kldfk', 'driver_head_icon' => 'xxx','driving_mileage' => 3755],
        ];
        $friend = [
            ['driver_id' => 2, 'name' => 'key', 'driver_head_icon' => 'xxx','consumption_per_100km' => 34],
            ['driver_id' => 3, 'name' => '风云', 'driver_head_icon' => 'xxx', 'consumption_per_100km' => 35],
            ['driver_id' => 4, 'name' => '明天更好','driver_head_icon' => 'xxx','consumption_per_100km' => 36],
            ['driver_id' => 5, 'name' => 'xxx','driver_head_icon' => 'xxx','consumption_per_100km' => 37],
            ['driver_id' => 6, 'name' => 'aaa','driver_head_icon' => 'xxx','consumption_per_100km' => 38],
            ['driver_id' => 7, 'name' => '1hd','driver_head_icon' => 'xxx','consumption_per_100km' => 39],
            ['driver_id' => 8, 'name' => '90jfe','driver_head_icon' => 'xxx','consumption_per_100km' => 45],
            ['driver_id' => 9, 'name' => 'fulkl','driver_head_icon' => 'xxx','consumption_per_100km' => 47],
            ['driver_id' => 10, 'name' => 'ffh','driver_head_icon' => 'xxx','consumption_per_100km' => 48],
            ['driver_id' => 21, 'name' => 'kldfk','driver_head_icon' => 'xxx','consumption_per_100km' => 58],
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
        ]];

        $this->data['error']['body']['data'] = array_merge($self, $result);

        echo json_en($this->data['error']);
        exit;
    }
}
