<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_score extends Admin_Controller {

    public function index()
    {
        $this->set_path('积分商品列表');
        
        $per_page = 16;    // 每页显示数量
        $offset = $this->input->get('per_page') ? $this->input->get('per_page') : 0;    // 当前页数量

        $where = array(
            // 'status' => 1,
        );

        // 组合搜索条件
        $search_str = '?';
        $this->data['product_name'] = $this->input->get('product_name');
        if (!empty($this->data['product_name'])) {
            $where['product_name like'] = '%'.$this->data['product_name'].'%';
            $search_str .= 'product_name='.$this->data['product_name'];
        }

        $this->data['total'] = $this->common_model->get_count('product_score', $where);
        
        // 分页初始化
        $page_config = array();
        $page_config['page_query_string'] = TRUE;
        $page_config['base_url'] = site_url(''.$this->appfolder.'/product_score/index/'.$search_str);
        $page_config['total_rows'] = $this->data['total'];
        $page_config['per_page'] = $per_page;
        $page_config['first_link'] = '第一页';
        $page_config['last_link'] = '最后一页';
        $page_config['prev_link'] = '上一页';
        $page_config['next_link'] = '下一页';
        $this->pagination->initialize($page_config);
        
        $this->data['data_list'] = $this->common_model->get_data('product_score', $where, $per_page, $offset, 'id', 'DESC')->result_array();
        if ($this->data['data_list']) {
            foreach ($this->data['data_list'] as $key => &$data) {
                $attachment_data = $this->attachment_service->get_attachment_by_id($data['attachment_id']);
                $data['product_img_http_file'] = $attachment_data['http_file'];
            }
        }

        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->view(''.$this->appfolder.'/product_score/product_score_view', $this->data);
    }
    
    public function add_data()
    {
        $this->set_path('添加积分商品');
        
        $this->load->view(''.$this->appfolder.'/product_score/add_product_score_view', $this->data);
    }
    
    public function act_add_data()
    {
        $product_name = $this->input->post('product_name');
        $product_desc = $this->input->post('product_desc');
        $product_img_attachment_id = $this->input->post('product_img_attachment_id');
        $exchange_type = $this->input->post('exchange_type');
        $exchange_num = $this->input->post('exchange_num');
        $status = $this->input->post('status');

        $product_attachment_id = '';
        if ($product_img_attachment_id) {
            $product_attachment_id = move_upload_file($product_img_attachment_id);
        }

        $this->common_model->trans_begin();
        
        $time = time();

        $data = array(
            'product_name' => $product_name,
            'product_desc' => $product_desc,
            'attachment_id' => $product_attachment_id,
            'exchange_type' => $exchange_type,
            'exchange_num' => $exchange_num,
            'status' => $status,
            'cretime' => $time,
            'updatetime' => $time,
        );
        $product_id = $this->common_model->insert('product_score', $data);

        // 插入日志
        $log_remark = '新增积分商品，积分商品ID：<a href="'.site_url(''.$this->appfolder.'/product_score/edit_data/'.$product_id.'').'">查看</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(600, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();
        
        redirect(''.$this->appfolder.'/product_score');
    }
    
    public function edit_data()
    {
        $this->set_path('编辑积分商品');
        
        $this->data['id'] = $this->input->get('id');
        
        // 积分商品数据
        $where = array(
            'id' => $this->data['id'],
        );
        $this->data['data'] = $this->common_model->get_data('product_score', $where)->row_array();

        $attachment_data = $this->attachment_service->get_attachment_by_id($this->data['data']['attachment_id']);
        $this->data['data']['product_img_http_file'] = $attachment_data['http_file'];

        $this->load->view(''.$this->appfolder.'/product_score/edit_product_score_view', $this->data);
    }
    
    public function act_edit_data()
    {
        $id = $this->input->post('id');
        $product_name = $this->input->post('product_name');
        $product_desc = $this->input->post('product_desc');
        $product_img_attachment_id = $this->input->post('product_img_attachment_id');
        $exchange_type = $this->input->post('exchange_type');
        $exchange_num = $this->input->post('exchange_num');
        $status = $this->input->post('status');

        $product_attachment_id = '';
        if ($product_img_attachment_id) {
            $product_attachment_id = move_upload_file($product_img_attachment_id);
        }

        $this->common_model->trans_begin();
        
        $time = time();

        $data = array(
            'product_name' => $product_name,
            'product_desc' => $product_desc,
            'attachment_id' => $product_attachment_id,
            'exchange_type' => $exchange_type,
            'exchange_num' => $exchange_num,
            'status' => $status,
            'cretime' => $time,
            'updatetime' => $time,
        );
        $where = array(
            'id' => $id,
        );
        $this->common_model->update('product_score', $data, $where);

        // 插入日志
        $log_remark = '新增积分商品，积分商品ID：<a href="'.site_url(''.$this->appfolder.'/product_score/edit_data/'.$product_id.'').'">查看</a>，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(601, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/product_score');
    }
    
    public function delete()
    {
        $id = $this->input->get('id');
        
        if (!is_numeric($id)) {
            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_begin();
        
        $data = array(
            'status' => 2,
        );
        $where = array(
            'id' => $id,
        );
        $this->common_model->update('product_score', $data, $where);

        // 插入日志
        $log_remark = '删除积分商品，积分商品ID：'.$id.'，管理员ID：<a href="'.site_url(''.$this->appfolder.'/admin/detail/'.$this->user_info['id'].'').'">'.$this->user_info['id'].'</a>';
        insert_admin_log(602, $log_remark, $this->user_info['id']);

        if ($this->common_model->trans_status() === FALSE) {
            $this->common_model->trans_rollback();

            show_error('操作失败，请重新操作，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $this->common_model->trans_commit();

        redirect(''.$this->appfolder.'/product_score');
    }

    public function ajax_search_strategy()
    {
        $country_id = $this->input->get('country_id', TRUE);
        $term = $this->input->get('term', TRUE);
        $term = trim($term);
        if (empty($term)) {
            echo json_encode(array());
            exit;
        }

        $q = ($term);

        $where = array(
            'name like' => '%'.$q.'%',
        );
        $items = $this->articles_model->get_data('article_categories', $where, '', '', 'id', 'DESC')->result_array();

        $result = array();
        foreach ($items as $key => $value) {
            if (empty($q)) {
                array_push($result, array("id"=>$value['id'], "label"=>$value['name'], "value" => $value['name']));
                    continue;
            }

            if (strpos(($value['name']), $q) !== false) {
                array_push($result, array("id"=>$value['id'], "label"=>$value['name'], "value" => $value['name']));
            }
        }

        echo json_encode($result);
        exit;
    }

    public function ajax_search_username()
    {
        $term = $this->input->get('term', TRUE);
        $term = trim($term);
        if (empty($term)) {
            echo json_encode(array());
            exit;
        }

        $q = ($term);

        $items = $this->common_model->get_data('vendors', array('name like' => '%'.$q.'%'))->result_array();

        $result = array();
        foreach ($items as $key => $value) {
            if (empty($q)) {
                array_push($result, array("id"=>$value['id'], "label"=>$value['name'], "value" => $value['name']));
                    continue;
            }

            if (strpos(($value['name']), $q) !== false) {
                array_push($result, array("id"=>$value['id'], "label"=>$value['name'], "value" => $value['name']));
            }
        }

        echo json_encode($result);
        exit;
    }
}

?>