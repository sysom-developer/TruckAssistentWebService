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
        $post['driver_id'] = trim($this->input->get_post('driver_id', true));
        $post['offset'] = trim($this->input->get_post('offset', true));
        $post['limit'] = trim($this->input->get_post('limit', true));
        $post['year'] = trim($this->input->get_post('year', true));
        $post['month'] = trim($this->input->get_post('month', true));
        $type='consumption_per_100km';
        $post['driver_id']=19;
        $post['offset']=0;
        $post['limit']=10;
        $post['year'] ='2016';
        $post['month']='05';
        $result = [];
        if($type == 'driving_mileage'){
            $result = $this->driving_mileage($post);
            $type='total_mileage';
        }
        elseif($type == 'consumption_per_100km'){
            $result = $this->consumption_per_100km($post);
            $type='consumption_per_km';
        }
        $where=['driver_id'=>$post['driver_id']];
        $data =$this->common_model->get_data('driver',$where)->result_array()[0];

        $rank=$this->ranking_model->getrank_by_device_id($data['device_no'],$type);
        $self = [
            'driver_id' => $post['driver_id'],
            'name' => $data['driver_name'],
            $type =>intval($rank[$type]),
            'driver_head_icon' => $data['driver_head_icon'],
            'ranking' => $rank['ranking'],
            'nick_name'=>$data['driver_nick_name']
        ];
        
        $this->data['error']['body']['data'] = array_merge($self, $result);

        echo json_en($this->data['error']);
        exit;
    }

    private function driving_mileage($post){
        return $this->ranking_model->ranking_type($post,'total_mileage');
    
    }

    private function consumption_per_100km($post){
       return $this->ranking_model->ranking_type($post,'consumption_per_km');
        
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
