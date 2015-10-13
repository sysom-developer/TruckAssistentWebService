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

/**
 * 
 * Android端扩展核心类
 *
 */
class Android_Controller extends CI_Controller {

    public $appfolder = "app_driver"; // 应用程序目录名
    public $error = array();
    
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

/**
 * 
 * 手机网站扩展核心类
 *
 */
class App_Web_Controller extends CI_Controller {

    public $appfolder = "app_web";
    public $shipper_info = array();
    public $data; // 模版传值数组
    
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

        $this->data['site_name'] = " - 途好运";

        $this->is_logined();

        if ($this->shipper_info) {
            if (
                    ($this->router->fetch_class() == 'login' || $this->router->fetch_class() == 'register') 
                    && $this->router->fetch_method() == 'index'
            ) {
                redirect(site_url($this->appfolder."/main"));
            }

            // 加载配置文件
            $this->load_config();

            return TRUE;
        }

        // 用户未登录，判断当前页面是否配置为不需要验证用户
        if ($this->is_ignore_login() === FALSE) {
            redirect($this->appfolder.'/login');
        }
    }

    /**
     * 
     * 加载后台导航，菜单配置文件
     */
    private function load_config() {
        $this->data['install_require'] = $this->config->item('install_require');
        $this->data['is_overranging'] = $this->config->item('is_overranging');
    }

    /**
     * 
     * 检查登录
     */
    public function is_logined() {
        // 检查cookie是否存在
        $encrypt_string = get_cookie($this->appfolder.'_shipper');
        if ($encrypt_string) {
            $decode_string = $this->encrypt->decode($encrypt_string);
            if (strpos($decode_string, '|')) {
                $array = explode('|', $decode_string);
                $shipper_id = htmlspecialchars($array[2]);
                $password = htmlspecialchars($array[3]);

                // $where = array(
                //     'shipper_id' => $shipper_id,
                //     'login_pwd' => $password,
                // );
                // $this->shipper_info = $this->shipper_service->get_shipper_data($where);
                // if ($this->shipper_info) {
                    
                // }
            }
        }
    }

    /**
     * 
     * 判断当前页面是否忽略登录判断
     */
    public function is_ignore_login() {
        $this->load->config($this->appfolder.'/ignore');
        $ignore_login = $this->config->item('ignore_login');

        return $this->is_controller_method_in_array($ignore_login);
    }

    /**
     * 
     * 工具函数，判断controller和method是否在数组中
     */
    public function is_controller_method_in_array(&$arr) {
        $controller = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        foreach ($arr as $key => $val) {
            if ($controller != $key && $controller != $val) {
                continue;
            }

            if (is_array($val)) {
                foreach ($val as $sub_val) {
                    if ($controller == $key && $method == $sub_val) {
                        return TRUE;
                    }
                }
            } else if ($controller == $val) {
                return TRUE;
            }
        }

        return FALSE;
    }
}

/**
 * 
 * 网站扩展核心类
 *
 */
class Public_Controller extends CI_Controller {

    public $data = array();
    public $shipper_info = array();
    
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

        $this->data['site_name'] = " - 途好运";

        $this->is_logined();

        if ($this->shipper_info) {
            if (
                    ($this->router->fetch_class() == 'login' || $this->router->fetch_class() == 'register') 
                    && $this->router->fetch_method() == 'index'
            ) {
                redirect(site_url("main"));
            }

            // 加载配置文件
            $this->load_config();

            return TRUE;
        }

        // 用户未登录，判断当前页面是否配置为不需要验证用户
        if ($this->is_ignore_login() === FALSE) {
            redirect('login');
        }
    }

    /**
     * 
     * 检查登录
     */
    public function is_logined() {
        // 检查cookie是否存在
        $encrypt_string = get_cookie('public_user');
        if ($encrypt_string) {
            $decode_string = $this->encrypt->decode($encrypt_string);
            if (strpos($decode_string, '|')) {
                $array = explode('|', $decode_string);
                $shipper_id = htmlspecialchars($array[2]);
                $password = htmlspecialchars($array[3]);

                $where = array(
                    'shipper_id' => $shipper_id,
                    'login_pwd' => $password,
                );
                $this->shipper_info = $this->shipper_service->get_shipper_data($where);
                if ($this->shipper_info) {

                }
            }
        }
    }

    /**
     * 
     * 判断当前页面是否忽略登录判断
     */
    public function is_ignore_login() {
        $this->load->config('ignore');
        $ignore_login = $this->config->item('ignore_login');

        return $this->is_controller_method_in_array($ignore_login);
    }

    /**
     * 
     * 工具函数，判断controller和method是否在数组中
     */
    public function is_controller_method_in_array(&$arr) {
        $controller = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        foreach ($arr as $key => $val) {
            if ($controller != $key && $controller != $val) {
                continue;
            }

            if (is_array($val)) {
                foreach ($val as $sub_val) {
                    if ($controller == $key && $method == $sub_val) {
                        return TRUE;
                    }
                }
            } else if ($controller == $val) {
                return TRUE;
            }
        }

        return FALSE;
    }
}

/**
 * 
 * 公版货主后台扩展核心类
 *
 */
class Public_MY_Controller extends CI_Controller {

    public $appfolder = "public_web_shipper"; // 应用程序目录名
    public $shipper_info = array();
    public $data; // 模版传值数组
    
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

        $this->data['site_name'] = " - 途好运";

        $this->is_logined();

        if ($this->shipper_info) {
            if (
                    ($this->router->fetch_class() == 'login' || $this->router->fetch_class() == 'register') 
                    && $this->router->fetch_method() == 'index'
            ) {
                redirect(site_url($this->appfolder."/main"));
            }

            // 加载配置文件
            $this->load_config();

            return TRUE;
        }

        // 用户未登录，判断当前页面是否配置为不需要验证用户
        if ($this->is_ignore_login() === FALSE) {
            redirect($this->appfolder.'/login');
        }
    }

    /**
     * 
     * 加载后台导航，菜单配置文件
     */
    private function load_config() {
        $this->data['install_require'] = $this->config->item('install_require');
        $this->data['is_overranging'] = $this->config->item('is_overranging');
    }

    /**
     * 
     * 检查登录
     */
    public function is_logined() {
        // 检查cookie是否存在
        $encrypt_string = get_cookie($this->appfolder.'_shipper');
        if ($encrypt_string) {
            $decode_string = $this->encrypt->decode($encrypt_string);
            if (strpos($decode_string, '|')) {
                $array = explode('|', $decode_string);
                $shipper_id = htmlspecialchars($array[2]);
                $password = htmlspecialchars($array[3]);

                $where = array(
                    'shipper_id' => $shipper_id,
                    'login_pwd' => $password,
                );
                $this->shipper_info = $this->shipper_service->get_shipper_data($where);
                if ($this->shipper_info) {
                    // 所有货主账户id
                    $where = array(
                        'company_id' => $this->shipper_info['company_id'],
                    );
                    $shipper_data_list = $this->shipper_service->get_shipper_data_list($where);
                    $this->shipper_info['shipper_ids'] = array();
                    if ($shipper_data_list) {
                        foreach ($shipper_data_list as $value) {
                            $this->shipper_info['shipper_ids'][] = $value['shipper_id'];
                        }
                    }
                    
                    // 司机关联货主信息
                    $where = array(
                        'shipper_company_id' => $this->shipper_info['company_id'],
                    );
                    $this->shipper_info['shipper_driver_data_list'] = $this->shipper_driver_service->get_shipper_driver_data_list($where);
                    $this->shipper_info['driver_ids'] = array();
                    if (!empty($this->shipper_info['shipper_driver_data_list'])) {
                        foreach ($this->shipper_info['shipper_driver_data_list'] as $value) {
                            $this->shipper_info['driver_ids'][$value['driver_id']] = $value['driver_id'];
                        }

                        // 不可用车辆 driver_id 集合
                        $this->shipper_info['carry_driver_ids'] = $this->shipper_driver_service->get_carry_driver_ids($this->shipper_info, 4);

                        // 可用车辆 driver_id 集合
                        $this->shipper_info['sleep_driver_ids'] = $this->shipper_driver_service->get_sleep_driver_ids($this->shipper_info);
                    }

                    // 货主头像
                    $attachment_data = $this->attachment_service->get_attachment_by_id($this->shipper_info['shipper_head_icon']);
                    $this->shipper_info['shipper_head_icon_http_file'] = $attachment_data['http_file'];

                    // 评分
                    $this->shipper_info['count_score'] = 3;

                    // 公司信息
                    $this->shipper_info['shipper_company_data'] = $this->shipper_company_service->get_shipper_company_by_id($this->shipper_info['company_id']);

                    // 草稿箱未查看的运单数
                    $get_draft_order_data_list = $this->orders_service->get_draft_orders_data_list();
                    $this->shipper_info['draft_order_count'] = count($get_draft_order_data_list);

                    // 异常消息
                    $this->shipper_info['driver_anomaly_count'] = 0;
                    $this->data['driver_anomaly'] = array();
                    if (!empty($this->shipper_info['driver_ids'])) {
                        $where = array(
                            'company_id' => $this->shipper_info['company_id'],
                            'status' => 1,
                        );
                        $driver_anomaly_data_list = $this->driver_anomaly_service->get_driver_anomaly_data_list($where);
                        if ($driver_anomaly_data_list) {
                            foreach ($driver_anomaly_data_list as $value) {
                                if ($value['is_view'] == 1) {
                                    // 异常消息总数
                                    $this->shipper_info['driver_anomaly_count'] += 1;
                                }

                                $where = array(
                                    'driver_anomaly_id' => $value['id'],
                                );
                                $driver_anomaly_attachment_data_list = $this->driver_anomaly_service->get_driver_anomaly_attachment_data_list($where);

                                $driver_anomaly_img_list = array();
                                if ($driver_anomaly_attachment_data_list) {
                                    foreach ($driver_anomaly_attachment_data_list as $value3) {
                                        $attachment_data = $this->attachment_service->get_attachment_by_id($value3['attachment_id']);
                                        $driver_anomaly_img_list[] = $attachment_data['http_file'];
                                    }
                                }

                                $driver_data = $this->driver_service->get_driver_by_id($value['driver_id']);
                                $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_head_icon']);
                                $driver_data['driver_head_icon_http_file'] = $attachment_data['http_file'];

                                $where = array(
                                    'driver_id' => $value['driver_id'],
                                );
                                $vehicle_data = $this->vehicle_service->get_vehicle_data($where);

                                $this->data['driver_anomaly'][] = array(
                                    'driver_data' => $driver_data,
                                    'vehicle_data' => $vehicle_data,
                                    'exce_desc' => $value['exce_desc'],
                                    'province_name' => $value['province_name'],
                                    'city_name' => $value['city_name'],
                                    'speedInKPH' => $value['speedInKPH'],
                                    'heading' => $value['heading'],
                                    'cretime' => date('Y年m月d日 H时i分', $value['cretime']),
                                    'driver_anomaly_img_list' => $driver_anomaly_img_list,
                                );
                            }
                        }
                    }

                    // 首次登陆获取积分
                    $this->shipper_company_service->day_get_score($this->shipper_info);
                }
            }
        }
    }

    /**
     * 
     * 判断当前页面是否忽略登录判断
     */
    public function is_ignore_login() {
        $this->load->config($this->appfolder.'/ignore');
        $ignore_login = $this->config->item('ignore_login');

        return $this->is_controller_method_in_array($ignore_login);
    }

    /**
     * 
     * 工具函数，判断controller和method是否在数组中
     */
    public function is_controller_method_in_array(&$arr) {
        $controller = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        foreach ($arr as $key => $val) {
            if ($controller != $key && $controller != $val) {
                continue;
            }

            if (is_array($val)) {
                foreach ($val as $sub_val) {
                    if ($controller == $key && $method == $sub_val) {
                        return TRUE;
                    }
                }
            } else if ($controller == $val) {
                return TRUE;
            }
        }

        return FALSE;
    }
}

/**
 * 
 * 货主后台扩展核心类
 *
 */
class MY_Controller extends CI_Controller {

    public $appfolder = "web_shipper"; // 应用程序目录名
    public $shipper_info = array();
    public $data; // 模版传值数组
    
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

        $this->data['site_name'] = " - 途好运";

        $this->is_logined();

        if ($this->shipper_info) {
            if (
                    ($this->router->fetch_class() == 'login' || $this->router->fetch_class() == 'register') 
                    && $this->router->fetch_method() == 'index'
            ) {
                redirect(site_url($this->appfolder."/main"));
            }

            // 加载配置文件
            $this->load_config();

            return TRUE;
        }

        // 用户未登录，判断当前页面是否配置为不需要验证用户
        if ($this->is_ignore_login() === FALSE) {
            redirect($this->appfolder.'/login');
        }
    }

    /**
     * 
     * 加载后台导航，菜单配置文件
     */
    private function load_config() {
        $this->data['install_require'] = $this->config->item('install_require');
        $this->data['is_overranging'] = $this->config->item('is_overranging');
    }

    /**
     * 
     * 检查登录
     */
    public function is_logined() {
        // 检查cookie是否存在
        $encrypt_string = get_cookie($this->appfolder.'_shipper');
        if ($encrypt_string) {
            $decode_string = $this->encrypt->decode($encrypt_string);
            if (strpos($decode_string, '|')) {
                $array = explode('|', $decode_string);
                $shipper_id = htmlspecialchars($array[2]);
                $password = htmlspecialchars($array[3]);

                $where = array(
                    'shipper_id' => $shipper_id,
                    'login_pwd' => $password,
                );
                $this->shipper_info = $this->shipper_service->get_shipper_data($where);
                $this->shipper_info['carry_driver_ids'] = array();
                $this->shipper_info['sleep_driver_ids'] = array();
                if ($this->shipper_info) {
                    // 所有货主账户id
                    $where = array(
                        'company_id' => $this->shipper_info['company_id'],
                    );
                    $shipper_data_list = $this->shipper_service->get_shipper_data_list($where);
                    $this->shipper_info['shipper_ids'] = array();
                    if ($shipper_data_list) {
                        foreach ($shipper_data_list as $value) {
                            $this->shipper_info['shipper_ids'][] = $value['shipper_id'];
                        }
                    }
                    
                    // 司机关联货主信息
                    $where = array(
                        'shipper_company_id' => $this->shipper_info['company_id'],
                    );
                    $this->shipper_info['shipper_driver_data_list'] = $this->shipper_driver_service->get_shipper_driver_data_list($where);
                    $this->shipper_info['driver_ids'] = array();
                    if (!empty($this->shipper_info['shipper_driver_data_list'])) {
                        foreach ($this->shipper_info['shipper_driver_data_list'] as $value) {
                            $this->shipper_info['driver_ids'][$value['driver_id']] = $value['driver_id'];
                        }

                        // 不可用车辆 driver_id 集合
                        $this->shipper_info['carry_driver_ids'] = $this->shipper_driver_service->get_carry_driver_ids($this->shipper_info, 4);

                        // 可用车辆 driver_id 集合
                        $this->shipper_info['sleep_driver_ids'] = $this->shipper_driver_service->get_sleep_driver_ids($this->shipper_info);
                    }

                    // 货主头像
                    $attachment_data = $this->attachment_service->get_attachment_by_id($this->shipper_info['shipper_head_icon']);
                    $this->shipper_info['shipper_head_icon_http_file'] = $attachment_data['http_file'];

                    // 评分
                    $this->shipper_info['count_score'] = 3;

                    // 公司信息
                    $this->shipper_info['shipper_company_data'] = $this->shipper_company_service->get_shipper_company_by_id($this->shipper_info['company_id']);

                    // 草稿箱未查看的运单数
                    $get_draft_order_data_list = $this->orders_service->get_draft_orders_data_list();
                    $this->shipper_info['draft_order_count'] = count($get_draft_order_data_list);

                    // 异常消息
                    $this->shipper_info['driver_anomaly_count'] = 0;
                    $this->data['driver_anomaly'] = array();
                    if (!empty($this->shipper_info['driver_ids'])) {
                        $where = array(
                            'driver_id' => $this->shipper_info['driver_ids'],
                            'status' => 1,
                        );
                        $driver_anomaly_data_list = $this->driver_anomaly_service->get_driver_anomaly_data_list($where);
                        if ($driver_anomaly_data_list) {
                            foreach ($driver_anomaly_data_list as $value) {
                                if ($value['is_view'] == 1) {
                                    // 异常消息总数
                                    $this->shipper_info['driver_anomaly_count'] += 1;
                                    continue;
                                }

                                $where = array(
                                    'driver_anomaly_id' => $value['id'],
                                );
                                $driver_anomaly_attachment_data_list = $this->driver_anomaly_service->get_driver_anomaly_attachment_data_list($where);

                                $driver_anomaly_img_list = array();
                                if ($driver_anomaly_attachment_data_list) {
                                    foreach ($driver_anomaly_attachment_data_list as $value3) {
                                        $attachment_data = $this->attachment_service->get_attachment_by_id($value3['attachment_id']);
                                        $driver_anomaly_img_list[] = $attachment_data['http_file'];
                                    }
                                }

                                $driver_data = $this->driver_service->get_driver_by_id($value['driver_id']);
                                $attachment_data = $this->attachment_service->get_attachment_by_id($driver_data['driver_head_icon']);
                                $driver_data['driver_head_icon_http_file'] = $attachment_data['http_file'];

                                $vehicle_data = $this->vehicle_service->get_vehicle_by_id($value['driver_id']);

                                $this->data['driver_anomaly'][] = array(
                                    'driver_data' => $driver_data,
                                    'vehicle_data' => $vehicle_data,
                                    'exce_desc' => $value['exce_desc'],
                                    'province_name' => $value['province_name'],
                                    'city_name' => $value['city_name'],
                                    'speedInKPH' => $value['speedInKPH'],
                                    'heading' => $value['heading'],
                                    'cretime' => date('Y年m月d日 H时i分', $value['cretime']),
                                    'driver_anomaly_img_list' => $driver_anomaly_img_list,
                                );
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * 
     * 判断当前页面是否忽略登录判断
     */
    public function is_ignore_login() {
        $this->load->config($this->appfolder.'/ignore');
        $ignore_login = $this->config->item('ignore_login');

        return $this->is_controller_method_in_array($ignore_login);
    }

    /**
     * 
     * 工具函数，判断controller和method是否在数组中
     */
    public function is_controller_method_in_array(&$arr) {
        $controller = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        foreach ($arr as $key => $val) {
            if ($controller != $key && $controller != $val) {
                continue;
            }

            if (is_array($val)) {
                foreach ($val as $sub_val) {
                    if ($controller == $key && $method == $sub_val) {
                        return TRUE;
                    }
                }
            } else if ($controller == $val) {
                return TRUE;
            }
        }

        return FALSE;
    }
}

/**
 * 
 * 客服后台扩展核心类
 *
 */
class Admin_Controller extends CI_Controller {

    public $appfolder = "web_admin"; // 应用程序目录名
    public $data; // 模版传值数组
    
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

        $this->data['title'] = "客服后台管理系统";

        $this->user_info = $this->is_logined();

        if ($this->user_info) {
            // 检查管理员权限
            $this->user_auth();

            // 加载配置文件
            $this->load_config();

            // 加载多语言种类
            $this->data['lang_type'] = get_lang_type_helper();

            // 设置语言cookie
            $this->set_lang();

            $this->data['current_navigation'] = !$this->uri->segment(4) ? 1 : $this->uri->segment(4);

            return TRUE;
        }

        // 用户未登录，判断当前页面是否配置为不需要验证用户
        if ($this->is_ignore_login() === FALSE) {
            redirect($this->appfolder.'/login');
        }
    }

    /**
     *
     * 设置语言cookie
     */
    public function set_lang() {
        $this->data['lang'] = $this->input->get('lang');
        if (!$this->data['lang'])
            $this->data['lang'] = 'ch';
        $cookie = array(
            'name' => 'lang',
            'value' => $this->data['lang'],
            'expire' => 0,
            'path' => '/'.$this->appfolder.'/'
        );
        $this->input->set_cookie($cookie);
    }

    /**
     *
     * 检查管理员权限
     */
    public function user_auth() {
        $controller_name = unserialize($this->user_info['controller_name']);
        $controller_name = $controller_name === false ? array() : $controller_name;
        if ($this->router->fetch_class() != 'main'    // 非后台首页
                &&
                $this->user_info['is_super_admin'] != 1 // 非超级管理员
                &&
                !in_array($this->router->fetch_class(), array('login', 'logout', 'general', 'upload_file')) // 非权限验证页面
                &&
                !in_array($this->router->fetch_class(), $controller_name)) {
            show_error('Sorry，没有权限，请<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }
    }

    /**
     * 
     * 加载后台导航，菜单配置文件
     */
    private function load_config() {
        $this->load->config($this->appfolder.'/menu');
        $this->data['navigation'] = $this->config->item('navigation');
        $this->data['menu'] = $this->config->item('menu');
        
        $this->data['config_driver_type'] = $this->config->item('config_driver_type');

        $this->data['install_require'] = $this->config->item('install_require');
        $this->data['is_overranging'] = $this->config->item('is_overranging');
    }

    /**
     * 
     * 生成当前位置
     */
    protected function set_path($path_name) {
        $this->data['path_name'] = $path_name;

        foreach ($this->data['menu'] as $key => $arr) {
            foreach ($arr as $k => $menu) {
                if (stripos($menu['controller_name'], '/') !== FALSE) {
                    $menu_arr = explode('/', $menu['controller_name']);
                    $menu['controller_name'] = $menu_arr[0];
                }

                if ($menu['controller_name'] == $this->router->fetch_class()) {
                    $current_navigation = $key;
                    $navigation_name = $this->data['navigation'][$key];

                    break;
                }
            }
        }

        $this->data['navigation_path'] = "<a href='" . site_url($this->appfolder.'/general/index/' . $current_navigation . '') . "' target='_parent'>" . $navigation_name . "</a>" . " &gt; " . $path_name;
    }

    /**
     * 
     * 检查登录
     */
    private function is_logined() {
        // 检查cookie是否存在
        $encrypt_string = get_cookie($this->appfolder);
        if ($encrypt_string) {
            $decode_string = $this->encrypt->decode($encrypt_string);
            if (strpos($decode_string, '|')) {
                $array = explode('|', $decode_string);
                $username = htmlspecialchars($array[1]);
                $password = htmlspecialchars($array[2]);

                $where = array(
                    'username' => $username,
                    'password' => $password,
                );
                $user_info = $this->common_model->get_data('admin', $where)->row_array();
                if ($user_info) {
                    return $user_info;
                }
            }
        }

        return FALSE;
    }

    /**
     * 
     * 判断当前页面是否忽略登录判断
     */
    public function is_ignore_login() {
        $this->load->config($this->appfolder.'/ignore');
        $ignore_login = $this->config->item('ignore_login');

        return $this->is_controller_method_in_array($ignore_login);
    }

    /**
     * 
     * 工具函数，判断controller和method是否在数组中
     */
    public function is_controller_method_in_array(&$arr) {
        $controller = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        foreach ($arr as $key => $val) {
            if ($controller != $key && $controller != $val) {
                continue;
            }

            if (is_array($val)) {
                foreach ($val as $sub_val) {
                    if ($controller == $key && $method == $sub_val) {
                        return TRUE;
                    }
                }
            } else if ($controller == $val) {
                return TRUE;
            }
        }

        return FALSE;
    }
}