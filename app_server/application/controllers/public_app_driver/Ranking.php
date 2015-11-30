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
    public function get_ranking_list()
    {
        $offset = trim($this->input->get_post('offset', true));
        $limit = trim($this->input->get_post('limit', true));
        $order = trim($this->input->get_post('order', true));

        if(empty($offset)){
            $offset = 0;
        }
        if (!is_numeric($offset) ) {
            $this->app_error_func(2398, 'offset 参数错误');
            exit;
        }

        if(empty($limit)){
            $limit = 0;
        }
        if (!is_numeric($limit) ) {
            $this->app_error_func(2397, 'limit 参数错误');
            exit;
        }
        if(empty($order)){
          $order = 'driving_mileage';
        }

        if($order == 'driving_mileage'){
            $ranking_list = [
                ['driver_id' => 2, 'name' => 'key', 'driving_mileage' => 4806],
                ['driver_id' => 3, 'name' => '风云','driving_mileage' => 4702],
                ['driver_id' => 4, 'name' => '明天更好','driving_mileage' => 4500],
                ['driver_id' => 5, 'name' => 'xxx','driving_mileage' => 4406],
                ['driver_id' => 6, 'name' => 'aaa','driving_mileage' => 4399],
                ['driver_id' => 7, 'name' => '1hd','driving_mileage' => 4298],
                ['driver_id' => 8, 'name' => '90jfe','driving_mileage' => 4100],
                ['driver_id' => 9, 'name' => 'fulkl','driving_mileage' => 4000],
                ['driver_id' => 10, 'name' => 'ffh','driving_mileage' => 3807],
                ['driver_id' => 21, 'name' => 'kldfk','driving_mileage' => 3755],
            ];
        }elseif($order == 'economic_mileage'){
          $ranking_list = [
              ['driver_id' => 3, 'name' => '11keyew', 'economic_mileage' => 4806],
              ['driver_id' => 4, 'name' => '风e云','economic_mileage' => 4702],
              ['driver_id' => 78, 'name' => '明ew天更好','economic_mileage' => 4500],
              ['driver_id' => 5, 'name' => 'xerxx','economic_mileage' => 4406],
              ['driver_id' => 6, 'name' => 'aada','economic_mileage' => 4399],
              ['driver_id' => 18, 'name' => '1hd','economic_mileage' => 4298],
              ['driver_id' => 8, 'name' => '9d0jfe','economic_mileage' => 4100],
              ['driver_id' => 9, 'name' => 'fudlkl','economic_mileage' => 4000],
              ['driver_id' => 10, 'name' => 'fdfh','economic_mileage' => 3807],
              ['driver_id' => 21, 'name' => 'kl12dfk','economic_mileage' => 3755],
          ];
        }


        $this->data['error']['body']['waybill_data_list'] = $ranking_list;

        echo json_en($this->data['error']);
        exit;
    }

}
