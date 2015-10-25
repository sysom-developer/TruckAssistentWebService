<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class City_service
 *
 */
class City_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_city_by_ids($ids) {
        $where = array(
            'class_id' => $ids,
        );
        $data = $this->common_model
            ->select('class_id as city_id, class_name as city_value')
            ->get_data('city', $where)->result_array();
        return $data;
    }

}