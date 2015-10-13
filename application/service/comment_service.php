<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_shipper_comment_driver_data($where) {
        $data = $this->common_model->get_data('shipper_comment_driver', $where, 1, 0)->row_array();

        return $data;
    }

    public function get_shipper_comment_driver_data_list($where = array(), $limit = '', $offset = 0, $order = 'id', $by = 'DESC') {
        $data = $this->common_model->get_data('shipper_comment_driver', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

    public function get_avg_driver_comment_by_id($driver_id)
    {
        $where = array(
            'driver_id' => $driver_id,
        );
        $data_list = $this->get_shipper_comment_driver_data_list($where);
        $comment_count = 0;
        if ($data_list) {
            $i = 0;
            foreach ($data_list as $value) {
                $comment_count += $value['comment_star'];

                $i++;
            }

            $comment_count = floor($comment_count / $i);
        }

        return $comment_count;
    }

}