<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * 运单mongo接口
 * @author andy0010
 *
 */

class logic_model{

    public function getMongo($db='logic')
    {

        $ip = '121.40.210.117';
        $conn = \League\Monga::connection($ip);
        return $conn->database($db);
    }


   
    /**
     * 根据ID查询行程
     * @param $device_no
     * @return mixed
     */
    public function get_current_logic($device_id,$ids){
        //生成查询条件
        $logics=array();

        foreach ($ids as $key => $value) {
            $cond = ['_id'=> $value];
            $logic = $this->getMongo()->collection($device_id)
            ->find($cond);
            $result = iterator_to_array($logic);
            $logic = array_values($result)[0]['vehicle_section'];
            $vehicle_driving_section=array();
            $vehicle_stop_section=array();
            foreach ($logic as $v => $vehicle_section) {
                if($vehicle_section['type'] == "vehicle_driving_section")
                    $vehicle_driving_section=$vehicle_section;
                else
                    $vehicle_stop_section=$vehicle_section;
            }
            $start_poi=json_decode(json_encode($vehicle_driving_section['start_poi']),TRUE);
            $end_poi=json_decode(json_encode($vehicle_driving_section['end_poi']),TRUE);
            $trip['mileage_id'] = $key;
            if(is_array($start_poi))
            {

                $trip['start_address'] =$start_poi[0]['addr'];
            }
            else
            {
                $start_poi=json_decode($start_poi,true);
                
                $trip['start_address'] =$start_poi['contents'][0]['address'];
            }
            if(is_array($end_poi))
            {
                $trip['end_address'] =$end_poi[0]['addr'];
                
            }
            else
            {
                $end_poi=json_decode($end_poi,true);
                $trip['end_address'] =$end_poi['contents'][0]['address'];
            }
            $trip['start_time'] =json_decode(json_encode($vehicle_driving_section['start_time']),true)['bin'];
            $trip['end_time'] =json_decode(json_encode($vehicle_driving_section['end_time']),true)['bin'];
            $trip['mileage'] =intval($vehicle_driving_section['distance']);
            $trip['amount_per_km'] =5.2*intval($vehicle_driving_section['fuel_quantity']);
            $trip['traffic']='平路';
            $logics[$key]=$trip;
/*            $trip['_id']=$value;
            if($key==2)
            {
                var_dump($logic);
                echo $value;exit;
            }*/
        }
        
        return $logics;
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
