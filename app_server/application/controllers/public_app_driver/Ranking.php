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
       /* $type='consumption_per_100km';*/
       /* $post['driver_id']=19;
        $post['offset']=0;
        $post['limit']=10;
        $post['year'] ='2016';
        $post['month']='05';*/
        $result = [];
        if($type == 'driving_mileage'){
            $result = $this->driving_mileage($post);
        }
        elseif($type == 'consumption_per_100km'){
            $result = $this->consumption_per_100km($post);
        }
        $where=['driver_id'=>$post['driver_id']];
        $data =$this->driver_service->get_driver_by_id($post['driver_id']);

        $rank=$this->ranking_model->getrank_by_device_id($data['device_no'],$type);
        $self = [
            'driver_id' => $post['driver_id'],
            'name' => $data['driver_name'],
            $type =>$rank[$type],
            'driver_head_icon' => $data['driver_head_icon'],
            'ranking' => $rank['ranking'],
            'nick_name'=>$data['driver_nick_name']
        ];
        
        $this->data['error']['body']['data'] = array_merge($self, $result);

        echo json_en($this->data['error']);
        exit;
    }

    private function driving_mileage($post){
        return $this->ranking_model->ranking_type($post,'driving_mileage');
    
    }

    private function consumption_per_100km($post){
       return $this->ranking_model->ranking_type($post,'consumption_per_100km');
        
    }

    public function detail(){

        $type = trim($this->input->get_post('type', true));
        $post['driver_id'] = trim($this->input->get_post('driver_id', true));
        $post['year'] = trim($this->input->get_post('year', true));
        $post['month'] = trim($this->input->get_post('month', true));
        
        $driver=$this->driver_service->get_driver_by_id($post['driver_id']);
        $post['device_id']=$driver['device_no'];
        $result=$this->ranking_model->getranklist($post,$type);

        $rank=$this->ranking_model->getrank_by_device_id($data['device_no'],$type);
        $self = [
            'driver_id' => $post['driver_id'],
            'name' => $driver['driver_name'],
            $type =>$rank[$type],
            'driver_head_icon' => $driver['driver_head_icon'],
            'ranking' => $rank['ranking'],
            'nick_name'=>$driver['driver_nick_name']
        ];

        $this->data['error']['body']['data'] = array_merge($self, $result);

        echo json_en($this->data['error']);
        exit;
    }
}
