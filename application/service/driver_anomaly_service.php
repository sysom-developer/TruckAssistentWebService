<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_anomaly_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_driver_anomaly_data($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        $data = $this->common_model->get_data('driver_anomaly', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_driver_anomaly_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('driver_anomaly', $where)->row_array();

        return $data;
    }

    public function get_driver_anomaly_data_list($where = array(), $limit = '', $offset = 0, $order = 'id', $by = 'DESC') {
        $data = $this->common_model->get_data('driver_anomaly', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

    public function get_driver_anomaly_attachment_data($where = array(), $limit = '', $offset = '', $order = 'id', $by = 'ASC') {
        $data = $this->common_model->get_data('relation_driver_anomaly_attachment', $where, $limit, $offset, $order, $by)->row_array();

        return $data;
    }

    public function get_driver_anomaly_attachment_data_list($where = array(), $limit = '', $offset = 0, $order = 'id', $by = 'ASC') {
        $data = $this->common_model->get_data('relation_driver_anomaly_attachment', $where, $limit, $offset, $order, $by)->result_array();

        return $data;
    }

}