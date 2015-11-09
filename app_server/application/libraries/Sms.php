<?php

class Sms {
	const account = 'xsa';
	const key = 'xsa123';
	const uri = 'http://121.199.48.186:1210';
	const sendsms_api = '/Services/MsgSend.asmx/SendMsg';
	
	private static $params = array('userCode'=>self::account,'userPass'=>self::key,'Channel'=>'1');
	
	/**
	 * 验证码短信内容
	 * @param 验证码 $code
	 * @param 失效时间 $invalid_time
	 * @return string
	 */
	public static function buildAuthCodeMessage($code, $invalid_time = 5){
		$content = "验证码：".$code."，请在".$invalid_time."分钟内完成输入，欢迎使用途好运！【途好运】";
		
		return $content;
	}
	
	/**
	 * 发车短信内容
	 * @param 司机姓名 $name
	 * @param 货车车牌号 $cardNum
	 * @param 发车日期 $startDate
	 * @param 发车地点 $startLoc
	 * @param 到达日期 $arriveDate
	 * @param 到达地点 $dstLocation
	 * @return string
	 */
	public static function buildDepartMessage($name, $cardNum, $startDate, $startLoc, $arriveDate, $dstLocation, $count){
		$content = $name."车牌号".$cardNum."于".$startDate."从".$startLoc."发车(本月第". $count ."车)，预计".$arriveDate."到达".$dstLocation."，请及时安排返程货源！【途好运】";
		
		return $content;
	}
	
	/**
	 * 位置信息短信内容
	 * @param 线路 $route_name
	 * @param 司机姓名 $name
	 * @param 货车车牌号 $cardNum
	 * @param 当前位置 $location
	 * @param 时间（hh:mm） $time
	 * @return string
	 */
	public static function buildLocationNotifyMessage($array, $type){
		$count = count($array, 0);
		if($type == 1){
			$content = $count . "辆在途（" . $array[0]['route_name'] . "）：";
		}else{
			$content = $count . "辆回程（" . $array[0]['route_name'] . "）：";
		}
		
		for($i = 0; $i < $count; $i++){
			$content .= ($i + 1). "." . $array[$i]['name']."车牌号".$array[$i]['cardNum']."位于".$array[$i]['location']."（".$array[$i]['time']."）";
		}
		
		$content .= "，该信息仅供参考！【途好运】";
		
		return $content;
	}
	
	/*
	 * 未在途车辆状态短信
	 * 
	 */
//	public static function buildVehicleStateMessage($vehicle_summary, $vehicle_detail){
//		$content = "在" . $vehicle_summary['location'] . $vehicle_summary['total_count'] . "台车,";
//		$content .= "今天发车" . $vehicle_summary['depart_count'] . "台,";
//		$content .= "无运单" . $vehicle_summary['nooder_count'] . "台;";
//
//		$count = count($vehicle_detail, 0);
//		for($i = 0; $i < $count; $i++){
//			$content .= $vehicle_detail[$i]['name']."(".$vehicle_detail[$i]['cardNum'].")";
//			$type = $array[$i]['type'];
//			if($type == 1){
//				$content .= $vehicle_detail[$i]['departTime'] ."发车,";
//			}else if($type == 2){
//				$content .= "有运单没接单,";
//			}else if($type == 3){
//				$content .= "有接单未发车";
//			}else if($type == 4){
//				$content .= "无运单";
//			}else{
//				$content .= "未知状态,";
//			}
//
//			$content .= "已在". $vehicle_detail[$i]['location'] . $vehicle_detail[$i]['duration'];
//		}
//
//		$content .= "，该信息仅供参考！【途好运】";
//
//		return $content;
//	}
	
	
	public static function buildArrivalNoticeMessage($array){
		$content = $array['name']."车牌号".$array['cardNum']."于". $array['time'] . "已经到达" . $array['location'] . "，请及时协调卸货、送货，以便当天能发车回" . $array['start_city'];
		
		
		$content .= "，该信息仅供参考！【途好运】";
		
		return $content;
	}
	
	public static function buildDelayNoticeMessage($array){
		$content = $array['name']."车牌号".$array['cardNum']."于". $array['time'] . "在" . $array['location'] . "停留超过" . $array['time_delay'] . "小时";
	
	
		$content .= "，该信息仅供参考！【途好运】";
	
		return $content;
	}
	
	//执行发送
	public static function sendSms($mobile,$message,$signal = '') {
		if (stripos($mobile, ",") !== FALSE) {
			$mobile_array = explode(",", $mobile);
			$mobile_array = array_filter($mobile_array);
			foreach ($mobile_array as $mobile) {
				self::$params['DesNo'] = $mobile;
				self::$params['Msg'] = $message;

				$sms_rtn = self::send(self::$params);
			}
		} else {
			self::$params['DesNo'] = $mobile;
			self::$params['Msg'] = $message;

			$sms_rtn = self::send(self::$params);
		}

		return $sms_rtn;
	}

	public static function send($params)
	{
		$url = self::uri.self::sendsms_api;

		$postdata = http_build_query(self::$params);
		
		$ch = curl_init($url);
	 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
		$response = curl_exec($ch);  //response: <string xmlns="http://tempuri.org/">-5</string>
		
		$array = json_decode(json_encode(simplexml_load_string($response)),TRUE); 
		
		$ret = $array[0];
		
		curl_close($ch);
		
		if($ret > 0){
			return true;
		}else{
			$msg = "send sms to {$params['DesNo']} failed,errorno: {$ret}";
//			log::getInstance()->LogMessage('SMS', $msg, log::ERROR);
			return false;
		}
	}
}