<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_score extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => '',
                ),
            ),
            'body' => array(),
        );
    }

    public function index()
    {
        $exchange_type = $this->input->get_post('exchange_type', TRUE);

        if (empty($this->data['driver_id'])) {
            $this->app_error_func(998, 'driver_id 参数错误');
            exit;
        }

        if (!in_array($exchange_type, array(1, 2))) {
            $this->app_error_func(998, 'exchange_type 参数错误');
            exit;
        }

        $where = array(
            'exchange_type' => $exchange_type,
        );
        $product_score_data_list = $this->product_score_service->get_product_score_data_list($where);
        $data_list = array();
        if ($product_score_data_list) {
            foreach ($product_score_data_list as $key => &$value) {
                $attachment_data = $this->attachment_service->get_attachment_by_id($value['attachment_id']);
                $value['product_img_http_file'] = $attachment_data['http_file'];

                $data_list[] = array(
                    'id' => $value['id'],
                    'product_name' => $value['product_name'],
                    'product_img_http_file' => $value['product_img_http_file'],
                    'exchange_num' => $value['exchange_num'],
                );
            }
        }

        $this->data['error']['body']['driver_score'] = $this->data['driver_data']['driver_score'];
        $this->data['error']['body']['data_list'] = $data_list;

        echo json_en($this->data['error']);
        exit;
    }
}