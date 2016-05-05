<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * 运单mongo接口
 * @author andy0010
 *
 */

class Waybill_model{

    public function getMongo($db='waybill')
    {
        $ip = '121.40.210.117';
        $conn = \League\Monga::connection($ip);
        return $conn->database($db);
    }
/**
     * 根据司机查询历史城市
     * @param $device_no
     * @param $limit
     * @return array
     */
    public function get_history_city($device_no, $count){
        $limit = $count;
/*        $data =  $this->getMongo()
            ->collection('waybill')
            ->find($where)
            ->select('end_city_id')
            ->limit($limit);
            ->group_by('end_city_id')
            ->get_data('waybill', $where, $limit, $offset = 0, $order = 'create_time', $by = 'DESC' )
            ->result_array();
        $ids = array_column($data, 'end_city_id');*/

            $waybills = $this->getMongo()->collection('settle'.$device_no)
                    ->find()
                    ->sort(['start_time' => -1])
                    ->skip($offset*$limit)
                    ->limit($limit);
        $data=iterator_to_array($waybills);
        
        $return=array();
        foreach ($data as $key => $value) {
            array_push($return,$value['end_city_name']);

        }
/*        $data = $this->city_service->get_city_by_ids($ids);
*/
//        echo $this->db->last_query();

        return array_unique($return);
    }
    /**
     * 根据设备号查询运单列表
     * @param $device_no
     * @param $limit
     * @return array
     */
    public function get_waybill_by_device_no($device_no, $offset, $limit, $start_time_from, $start_time_to,$type){

        //生成查询条件
        $q = function($query) use ($device_no, $start_time_from, $start_time_to){
            $query->WhereBetween('start_time', intval($start_time_from), intval($start_time_to));
        };
        if($type==1)
        {
            $waybills = $this->getMongo()->collection('waybill'.$device_no)
                    ->find($q)
                    ->sort(['start_time' => -1])
                    ->skip($offset*$limit)
                    ->limit($limit);
        }
        else{
            $waybills = $this->getMongo()->collection('settle'.$device_no)
                    ->find($q)
                    ->sort(['start_time' => -1])
                    ->skip($offset*$limit)
                    ->limit($limit);
        }
        
        $result = iterator_to_array($waybills);
      
        return $result;
    }

    /**
     * 根据设备号查询当前运单
     * @param $device_no
     * @return mixed
     */
    public function get_current_waybill($device_no,$type){
        //生成查询条件
        /*$cond = ['device_id'=> $device_no];*/
        if($type==1)
        {
        $waybills = $this->getMongo()->collection('waybill'.$device_no)
            ->find()
            ->sort(['_id' => -1])
            ->limit(1);
        }
        else
        {
            $waybills = $this->getMongo()->collection('settle'.$device_no)
            ->find()
            ->sort(['_id' => -1])
            ->limit(1);
        }
        $result = iterator_to_array($waybills);
        return array_values($result);
    }

    /**
     * 根据运单id获取运单详情
     * @param $waybill_id
     * @return mixed
     */
    public function get_waybill_by_id($waybill_id){
        //根据运单id获取运单
        $cond = ['_id'=> new \MongoId($waybill_id)];
        $waybill = $this->getMongo()->collection('waybill')->findOne($cond);
        return $waybill;
    }


}
