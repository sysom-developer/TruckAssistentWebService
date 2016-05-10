<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * 排行榜mongo接口
 * @author andy0010
 *
 */

class ranking_model extends Common_model{

    public function getMongo($db='follow')
    {

        $ip = '121.40.210.117';
        $conn = \League\Monga::connection($ip);
        return $conn->database($db);
    }
       /**
     * 添加关注
     * @param $followed_driver_id,follower_driver_id
     * @return mixed
     */
    public function follow($followed_driver_id,$follower_driver_id){

        $data = ['driver_id'=> $followed_driver_id];
        if($this->getMongo()->collection('driver_id_'.$follower_driver_id)->count($data)!= 0)
        {
        	return "已关注";
        }
        $return = $this->getMongo()->collection('driver_id_'.$follower_driver_id)->insert($data);
        return "关注成功";
    }
      /**
     * 取消关注
     * @param $followed_driver_id,follower_driver_id
     * @return mixed
     */
    public function unfollow($followed_driver_id,$follower_driver_id){

        $where = ['driver_id'=> $followed_driver_id];
        $return = $this->getMongo()->collection('driver_id_'.$follower_driver_id)->remove($where);
        return "取消成功";
    }
     /**
     * 根据设备id获取排行数据
     * @param $driver_id
     * @return mixed
     */
    public function getrank_by_device_id($device_id,$type){
    	$where=['device_id'=>$device_id];
    	$field=["_id"=>false,$type=>true,'device_id'=>true];
    	$rank=$this->getMongo('waybill')->collection('total')->find($where)
    		->fields($field);
    	$rank=iterator_to_array($rank)[0];
    	  
    	$where=[$type =>['$gt'=>$rank[$type]]];
    	
		$count=$this->getMongo('waybill')->collection('total')->find($where)
    		->count();

    	$rank['ranking']=$count+1;	
        return  $rank;
    }
     /**
     * 排行
     * @param $driver_id
     * @return mixed
     */
    public function ranking_type($post,$type){
    	$time = ['time'=> $post['year'].'-'.$post['month']];

    	$field=["$type"=>true,"device_id"=>true,"_id"=>false];
    	$friend=$this->getMongo('waybill')->collection('total')->find($time)
    		->fields($field)
    	    ->sort([$type => -1])
            ->skip($post['offset']*$post['limit'])
            ->limit($post['limit']);
       	$friend=iterator_to_array($friend);
       
       	foreach ($friend as $key => $value) {
        	$where=['device_no'=>$value['device_id']];

        	$data =$this->common_model->get_data('driver',$where)->result_array()[0];
        	
        	$friend[$key]['name']=$data['driver_name'];
        	$friend[$key]['nick_name']=$data['driver_nick_name'];
        	$friend[$key]['driver_head_icon']=$data['driver_head_icon'];
        	$friend[$key]['ranking']=$key+1;
        	$friend[$key][$type]=intval($friend[$key][$type]);
        }
        $field=["_id"=>false];

        $follows_id = $this->getMongo()->collection('driver_id_'.$post['driver_id'])->find()
        	->fields($field)
        	->sort([$type => -1])
            ->skip($post['offset']*$post['limit'])
            ->limit($post['limit']);
        $follows_id=iterator_to_array($follows_id);
  
        $array=array();
        foreach ($follows_id as $key => $value) {
        	$array[$key]=$value['driver_id'];
        }
        $follows=array();

        $data = $this->common_model->get_data('driver',['driver_id'=>$array])->result_array();

       /*  echo $this->db->last_query();*/
       $field=[$type=>true,"device_id"=>true,"_id"=>false];
        foreach ($data as $key => $value) {
        	$where=['device_id'=>$value['device_no']];

        	$follow_ls_m = iterator_to_array($this->getMongo('waybill')->collection('total')->find($where)->fields($field))[0];
        	
        	$follow_ls['name']=$value['driver_name'];
        	$follow_ls['nick_name']=$value['driver_nick_name'];
        	$follow_ls['driver_head_icon']=$value['driver_head_icon'];
        	$follow_ls['ranking']=$key+1;
        	$follow_ls[$type]=intval($follow_ls_m[$type]);
        	array_push($follows,$follow_ls);
        }
 
        return ['friend'=>$friend,'follow'=>$follows];
    }
    
}