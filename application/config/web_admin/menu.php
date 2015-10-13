<?php

/**
 * 
 * 后台导航配置文件 
 */

$config['navigation'] = array(
    1 => '系统管理',
    2 => '运单管理',
    3 => '司机管理',
    4 => '调度管理',
    5 => '线路管理',
    6 => '货运公司管理',
    7 => '积分商品管理',
    9 => '日志管理',
);

/**
 *
 * 后台菜单配置文件
 */
$config['menu'] = array(
    1 => array(
        1 => array(
    		'menu_name' => '后台首页',
			'controller_name' => 'main',
        ),
        2 => array(
            'menu_name' => '管理员模块',
            'controller_name' => 'admin',
        ),
		3 => array(
			'menu_name' => '部门模块',
            'controller_name' => 'admin_department',
		),
    ),
    2 => array(
        1 => array(
            'menu_name' => '运单列表',
            'controller_name' => 'order',
        ),
        2 => array(
            'menu_name' => '可用车辆异常列表',
            'controller_name' => 'sleep_vehicle_anomaly',
        ),
        3 => array(
            'menu_name' => '在途车辆异常列表',
            'controller_name' => 'carry_vehicle_anomaly',
        ),
        4 => array(
            'menu_name' => '完成未确认异常列表',
            'controller_name' => 'finished_order_not_ok_anomaly',
        ),
    ),
    3 => array(
        1 => array(
            'menu_name' => '司机列表',
            'controller_name' => 'driver',
        ),
        2 => array(
            'menu_name' => '车辆列表',
            'controller_name' => 'vehicle',
        ),
        3 => array(
            'menu_name' => '车辆类型列表',
            'controller_name' => 'vehicle_type',
        ),
        4 => array(
            'menu_name' => '车辆长度属性列表',
            'controller_name' => 'vehicle_length',
        ),
        5 => array(
            'menu_name' => '车辆载重属性列表',
            'controller_name' => 'vehicle_load',
        ),
        6 => array(
            'menu_name' => '意见反馈列表',
            'controller_name' => 'report',
        ),
    ),
    4 => array(
        1 => array(
            'menu_name' => '调度角色列表',
            'controller_name' => 'user_dispatch',
        ),
        2 => array(
            'menu_name' => '司机关联调度列表',
            'controller_name' => 'relation_driver_user_dispatch',
        ),
    ),
    5 => array(
        1 => array(
            'menu_name' => '货运公司关联线路列表',
            'controller_name' => 'shipper_route',
        ),
        2 => array(
            'menu_name' => '线路列表',
            'controller_name' => 'route',
        ),
    ),
    6 => array(
        1 => array(
            'menu_name' => '货运公司列表',
            'controller_name' => 'shipper_company',
        ),
        2 => array(
            'menu_name' => '货主列表',
            'controller_name' => 'shipper',
        ),
        3 => array(
            'menu_name' => '司机关联货运公司列表',
            'controller_name' => 'relation_shipper_driver',
        ),
    ),
    7 => array(
        1 => array(
            'menu_name' => '积分商品列表',
            'controller_name' => 'product_score',
        ),
    ),
    9 => array(
        1 => array(
            'menu_name' => '日志模块',
            'controller_name' => 'admin_log',
        ),
    ),
);

?>