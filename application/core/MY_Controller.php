<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * 公版Android端扩展核心类
 *
 */
class Public_Android_Controller extends CI_Controller {

    public $appfolder = "public_app_driver"; // 应用程序目录名
    public $error = array();
    //司机信息
    public $driver_data = array();
    
    public function __construct()
    {
        // 强制时区为PRC
        date_default_timezone_set('PRC');

        // 强行设置编码
        header("Content-type: text/html; charset=utf-8");

        // 继承主控制器
        parent::__construct();

        // 评测器
        $enable_profiler = FALSE;
        if ($this->input->get('y') == 1) {
            $enable_profiler = TRUE;
        }
        $this->output->enable_profiler($enable_profiler);

        // 调试参数
        $this->data['n'] = $this->input->get_post('n', TRUE);

        // 当前类名
        $this->data['fetch_class'] = $this->router->fetch_class();
        
        // 当前方法名
        $this->data['fetch_method'] = $this->router->fetch_method();

        //如果是已登陆，获取司机信息
        $this->data['driver_id'] = $this->input->get_post('driver_id', TRUE);

        if (is_numeric($this->data['driver_id']) && $this->data['driver_id'] > 0) {
            // 司机信息
            $where = array(
                'driver_id' => $this->data['driver_id'],
            );
            $this->data['driver_data'] = $this->driver_service->get_driver_data($where);

            // 司机所属货运公司
            $where = array(
                'driver_id' => $this->data['driver_id'],
            );
            $this->data['shipper_driver_data'] = $this->shipper_driver_service->get_shipper_driver_data($where);

            // 司机所属货运公司信息
            $this->data['shipper_company_data'] = $this->shipper_company_service->get_shipper_company_by_id($this->data['shipper_driver_data']['shipper_company_id']);
        }

        return TRUE;
    }

    public function app_error_func($code, $error_desc)
    {
        $this->data['error']['application']['head']['code'] = $code;
        $this->data['error']['application']['head']['description'] = $error_desc;
        echo json_en($this->data['error']);
        exit;
    }
}