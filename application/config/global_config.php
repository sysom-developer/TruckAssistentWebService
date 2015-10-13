<?php

// 运单 order_type 文字描述
$config['order_type_desc'] = array(
    1 => '草稿',
    2 => '待接',
    3 => '已接（待运）',
    4 => '在途（已运）',
    5 => '完成',
    6 => '已取消',
);

// 司机认证状态
$config['config_driver_type'] = array(
    0 => '账号未认证',
    1 => '认证通过',
    2 => '账号审核中',
    3 => '账号认证失败',
);

// 装卸要求
$config['install_require'] = array(
    1 => array(
        'id' => 1,
        'name' => '两装两卸',
    ),
    2 => array(
        'id' => 2,
        'name' => '一装一卸',
    ),
    3 => array(
        'id' => 3,
        'name' => '一装两卸',
    ),
);

// 是否超限
$config['is_overranging'] = array(
    1 => array(
        'id' => 1,
        'name' => '未超限',
    ),
    2 => array(
        'id' => 2,
        'name' => '超重',
    ),
    3 => array(
        'id' => 3,
        'name' => '超高',
    ),
    4 => array(
        'id' => 4,
        'name' => '超宽',
    ),
);