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
        $ip = '127.0.0.1';
        $conn = \League\Monga::connection($ip);
        return $conn->database($db);
    }


    /**
     * 根据设备号查询运单列表
     * @param $device_no
     * @param $limit
     * @return array
     */
    public function get_waybill_by_device_no($device_no, $offset, $limit, $start_time_from, $start_time_to){
        //生成查询条件
        $q = function($query) use ($device_no, $start_time_from, $start_time_to){
            $query->where('device_id', $device_no)
                ->andWhereBetween('start_time', intval($start_time_from), intval($start_time_to));
        };

        $waybills = $this->getMongo()->collection('waybill')
                    ->find($q)
                    ->sort(['start_time' => -1])
                    ->skip($offset*$limit)
                    ->limit($limit);
        $result = iterator_to_array($waybills);
        return $result;
    }

    /**
     * 根据设备号查询当前运单
     * @param $device_no
     * @return mixed
     */
    public function get_current_waybill($device_no){
        //生成查询条件
        $cond = ['device_id'=> $device_no];
        $waybills = $this->getMongo()->collection('waybill')
            ->find($cond)
            ->sort(['start_time' => -1])
            ->limit(1);
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