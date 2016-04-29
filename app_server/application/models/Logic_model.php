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
        $logic_data=array();
        $logic_data['total_mileage']=0;
        //生成查询条件
        $logics=array();
        $data=array();
        $i=0;
/*        $youjia=5.2;
        $total_fuel_quantity=0;
        $total_mileage=0;
        $total_time=0;
        $consumption_amount=0;*/
/*        for ($i=sizeof($ids)-20; $i <sizeof($ids); $i++) { 
            $cond = ['_id'=> $ids[$i]];
            $logic = $this->getMongo()->collection($device_id)
            ->find($cond);
            $data[$i]=$logic;
        }*/

        foreach ($ids as $key => $value) {
            $cond = ['_id'=> $value];
            $logic = $this->getMongo()->collection($device_id)
            ->find($cond);
            $data[$i]=$logic;
            $i++;
            /*$data[$i]['_id']=$value;*/
        }
       $i=0;
        foreach ($data as $logic) {
                
            /*$cond = ['_id'=> $value];
            $logic = $this->getMongo()->collection($device_id)
            ->find($cond);*/
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
            
            $start_poi=$this->getpoi($vehicle_driving_section['start_poi']);

            $end_poi=$this->getpoi($vehicle_driving_section['end_poi']);

            $trip['mileage_id'] = $i;
            if($start_poi == null)
            {
                if($vehicle_driving_section['start_time']>$vehicle_stop_section['start_time'])
                {
                    if($i>=1)
                    {
                    $start_poi_ls=$this->getpro_poi($data[$i-1],1);
                    }
                    if($start_poi_ls == null)
                        {
                            if($i>=1)
                            {
                            $start_poi=$logics[$i-1]['end_address'];
                            }
                        }
                    else{
                        $start_poi=$start_poi_ls;
                    }    
                    
                }
                else{
                    $start_poi=$this->getpoi($vehicle_stop_section['poi']);
                }
            }
            $trip['start_address'] =$start_poi;
            if($i>=1)
            {
            if($logics[$i-1]['end_address']==null)
            {
                $logics[$i-1]['end_address']=$trip['start_address'];
            }
            }
            if($end_poi == null)
            {
                if($vehicle_driving_section['start_time']>$vehicle_stop_section['start_time'])
                {
                    $end_poi=$this->getpoi($vehicle_stop_section['poi']);
                   
                }
                else{
                     $end_poi=$this->getpro_poi($data[$i+1],2);
                }
            }
            $trip['end_address'] =$end_poi;
            $trip['start_time'] =$vehicle_driving_section['start_time'];
            $trip['end_time'] = $vehicle_driving_section['end_time'];
            
            if($trip['start_time']==null)
            {
                if($i>=1)
            {
                $trip['start_time']=$this->gettime($data[$i-1],2);
            }
            }
            if($trip['end_time']==null)
            {
                $trip['end_time']=$this->gettime($data[$i+1],1);
            }
            /*echo floatval($vehicle_driving_section['distance']);*/
            $trip['mileage'] =round(floatval($vehicle_driving_section['distance']),2);
            /*echo $trip['mileage'];*/
            $trip['amount_per_km'] =round($youjia*floatval($vehicle_driving_section['fuel_quantity']/$trip['mileage']),2);
            $trip['traffic']='平路';
            /*$trip['_id']=$result['_id'];*/
            $logics[$i]=$trip;
            $i++;
      /*    $total_mileage+=$trip['mileage'];*/
          /*$total_time+=$vehicle_driving_section['time_interval'];
          $total_time+=$vehicle_stop_section['time_interval'];*/
            
  /*       $consumption_amount+=$youjia*floatval($vehicle_driving_section['fuel_quantity']);
         $consumption_amount+=$youjia*floatval($vehicle_stop_section['fuel_quantity']);*/
         
        }

        /*$total_fuel_quantity=round($consumption_amount/$youjia,2);
        echo "$total_fuel_quantity";
        echo "$total_mileage";
        exit;
        $logic_data['consumption_per_km']=round($total_fuel_quantity/$total_mileage*100,2);

        $logic_data['amount_per_km']=$logic_data['consumption_per_km']/100*$youjia;

        $logic_data['consumption_amount']=$consumption_amount;
       
       $logic_data['total_mileage']=$total_mileage;
       $logic_data['average_velocity']=round($logic_data['total_mileage']/($total_time/60/60),2);
       $logic_data['total_mileage']=$total_mileage;*/
        /*var_dump($logic_data['consumption'][0]);
        exit;*/
        $logic_data['consumption']=$logics;
        return $logic_data;
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
    public function getcity($data){
        $poi=json_decode(json_encode($data),TRUE);
        if(is_array($poi))
            {
               return  $poi[0]['city'];
            }
        else
            {
                $poi=json_decode($poi,true);
                return  $poi['contents'][0]['city'];
            }
    }
    public function getpoi($data){
        $poi=json_decode(json_encode($data),TRUE);
        if(is_array($poi))
            {
               return  $poi[0]['addr'];
            }
        else
            {
                $poi=json_decode($poi,true);
                return  $poi['contents'][0]['address'];
            }
    }
    public function gettime($data,$type){
         $result_pro = iterator_to_array($data);
        $logic_pro = array_values($result_pro)[0]['vehicle_section'];
            if($type==1)
            {
                return  $logic_pro[0]['start_time'];
            }
            else
            {
                return  $logic_pro[1]['end_time'];
            }
    }
    public function getpro_poi($data,$type){
         $result_pro = iterator_to_array($data);
        $logic_pro = array_values($result_pro)[0]['vehicle_section'];
        $vehicle_driving_section_pro=array();
        foreach ($logic_pro as $v => $vehicle_section) {
                if($vehicle_section['type'] == "vehicle_driving_section")
                    {
                        $vehicle_driving_section_pro=$vehicle_section;
                    }
                    }
            if($type==1)
            {
                return $this->getpoi($vehicle_driving_section_pro['end_poi']);
            }
            else
            {
                return $this->getpoi($vehicle_driving_section_pro['start_poi']);
            }
        
    }

}
