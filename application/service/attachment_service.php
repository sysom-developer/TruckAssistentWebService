<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Attachment_service
 * 附件表，存放图片
 */
class Attachment_service extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get_attachment_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('attachment', $where)->row_array();
        $data['http_file'] = static_url($data['filepath'].$data['filename']);

        $result = empty($data['http_file'])? '':$data['http_file'];
        return $result;
    }

    public function get_attachment_tmp_by_id($id) {
        $where = array(
            'id' => $id,
        );
        $data = $this->common_model->get_data('attachment_tmp', $where)->row_array();

        return $data;
    }

    public function get_attachment_data_list($order = 'id', $by = 'ASC') {
        $where = array();
        $data = $this->common_model->get_data('attachment', $where, '', '', $order, $by)->result_array();

        return $data;
    }

}