<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $title?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,p,blockquote,th,td{ margin:0;padding:0;}
        table{ border-collapse:collapse;border-spacing:0;}
        fieldset,img{ border:0;}
        ol,ul,li{ list-style:none; list-style-position:outside;}
        img{ border:0;}
        body{font-size:12px; background:#FFF; font-family:"微软雅黑"; color:#000; line-height:24px;}
        a{text-decoration:none;color:#0675ce;}
        a:hover{text-decoration: underline; color: #ff0000;}
        input,textarea,select,button{font-size:12px;font-family:"微软雅黑";}
        ul li{float:left; display:inline; overflow:hidden;}
    </style>
</head>

<body>
<?php
switch (ENVIRONMENT) {
    case 'development':
        $domain = 'http://local.newtuhaoyun.com/'.$this->appfolder;
        break;
    case 'production':
        $domain = 'http://www.thy56.com/'.$this->appfolder;
        break;
    default:
        exit('999');
}
?>
<form action="<?php echo $domain?>/seccode/get_sms_seccode" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">1. 注册 － 获取验证码</td>
            <td><?php echo $domain?>/seccode/get_sms_seccode</td>
        </tr>
        <tr>
            <td>手机号码（mobile_phone）</td>
            <td><input type="text" name="mobile_phone" value="138xxxxxxxx"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/register" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">2. 注册</td>
            <td><?php echo $domain?>/register</td>
        </tr>
        <tr>
            <td>手机号码（mobile_phone）</td>
            <td><input type="text" name="mobile_phone" value="138xxxxxxxx"></td>
        </tr>
        <tr>
            <td>密码（password）</td>
            <td><input type="password" name="password" value="123456"></td>
        </tr>
        <tr>
            <td>验证码（seccode）</td>
            <td><input type="text" name="seccode" value=""></td>
        </tr>
        <tr>
            <td>设备（device）</td>
            <td><input type="text" name="device" value="123456"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/login" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">3. 登录</td>
            <td><?php echo $domain?>/login</td>
        </tr>
        <tr>
            <td>手机号码（mobile_phone）</td>
            <td><input type="text" name="mobile_phone" value="138xxxxxxxx"></td>
        </tr>
        <tr>
            <td>密码（password）</td>
            <td><input type="password" name="password" value="123456"></td>
        </tr>
        <tr>
            <td>设备号（device）</td>
            <td><input type="text" name="device" value=""></td>
        </tr>
        <tr>
            <td>型号（model）</td>
            <td><input type="text" name="model" value=""></td>
        </tr>
        <tr>
            <td>版本号（version）</td>
            <td><input type="text" name="version" value=""></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/vehicle/get_vehicle_type" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">4. 获取车辆类型</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_type</td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/vehicle/get_vehicle_load" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">5. 获取车辆载重</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_load</td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/vehicle/get_vehicle_length" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">6. 获取车辆长度</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_length</td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/member/update_info" method="post" enctype="multipart/form-data">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">7. 完善资料（post）</td>
            <td><?php echo $domain?>/member/update_info</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="70"></td>
        </tr>
        <tr>
            <td>车牌号码（vehicle_card_num）</td>
            <td><input type="text" name="vehicle_card_num" value="皖BY7881"></td>
        </tr>
        <tr>
            <td>车辆类型（vehicle_type）</td>
            <td><input type="text" name="vehicle_type" value="1"></td>
        </tr>
        <tr>
            <td>车辆载重（vehicle_load）</td>
            <td><input type="text" name="vehicle_load" value="2"></td>
        </tr>
        <tr>
            <td>车辆长度（vehicle_length）</td>
            <td><input type="text" name="vehicle_length" value="3"></td>
        </tr>
        <tr>
            <td>驾驶证照片（driver_license_icon）</td>
            <td><input type="file" name="driver_license_icon"></td>
        </tr>
        <tr>
            <td>行驶证照片（driver_vehicle_license_icon）</td>
            <td><input type="file" name="driver_vehicle_license_icon"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<!-- <form action="<?php echo $domain?>/logout" method="get">
<table style="margin-left: 30px;" width="100%">
    <tr style="font-weight: bold; font-size: 14px;">
        <td width="300">登出</td>
        <td><?php echo $domain?>/logout</td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="提 交"></td>
    </tr>
    <tr>
        <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
    </tr>
</table>
</form> -->

<form action="<?php echo $domain?>/seccode/get_sms_seccode" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">8. 修改密码 － 获取验证码</td>
            <td><?php echo $domain?>/seccode/get_sms_seccode</td>
        </tr>
        <tr>
            <td>手机号码（mobile_phone）</td>
            <td><input type="text" name="mobile_phone" value="138xxxxxxxx"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/member/reset_password" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">9. 修改密码</td>
            <td><?php echo $domain?>/member/reset_password</td>
        </tr>
        <tr>
            <td>手机号码（mobile_phone）</td>
            <td><input type="text" name="mobile_phone" value="138xxxxxxxx"></td>
        </tr>
        <tr>
            <td>密码（password）</td>
            <td><input type="password" name="password" value="123456"></td>
        </tr>
        <tr>
            <td>验证码（seccode）</td>
            <td><input type="text" name="seccode" value=""></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/member/add_report" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">10. 意见反馈</td>
            <td><?php echo $domain?>/member/add_report</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="1"></td>
        </tr>
        <tr>
            <td>设备信息（device）</td>
            <td><input type="text" name="device" value="123456"></td>
        </tr>
        <tr>
            <td>反馈内容（content）</td>
            <td>
                <textarea name="content">测试反馈内容</textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/order" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">11. 发车记录</td>
            <td><?php echo $domain?>/order</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td>当前页数（cur_page）</td>
            <td><input type="text" name="cur_page" value="1"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/order/detail" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">12. 发车记录 － 查看详情</td>
            <td><?php echo $domain?>/order/detail</td>
        </tr>
        <tr>
            <td>订单ID（order_id，请求 发车记录 接口会得到）</td>
            <td><input type="text" name="order_id" value="9"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/main" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">13. 首页 － 发车数量</td>
            <td><?php echo $domain?>/main</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/shipper/get_all_data_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">14. 首页 － 获取所有货运公司</td>
            <td><?php echo $domain?>/shipper/get_all_data_list</td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/shipper/get_data_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">15. 首页 － 获取货运公司</td>
            <td><?php echo $domain?>/shipper/get_data_list</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td>司机当前省份名称（current_province_name）</td>
            <td><input type="text" name="current_province_name" value="上海"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/get_driver_address" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">16. 首页 － 获取常用地址</td>
            <td><?php echo $domain?>/driver/get_driver_address</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td>地址类型（address_type）</td>
            <td>
                <select name="address_type">
                    <option value="1">起点（value=1）</option>
                    <option value="2">终点（value=2）</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/region/get_history_region_data_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">17. 获取历史城市信息（返回 city_id）</td>
            <td><?php echo $domain?>/region/get_history_region_data_list</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td>起点或终点（select_type）：</td>
            <td>
                <select name="select_type">
                    <option value="1">起点</option>
                    <option value="2">终点</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/region/get_hot_region_data_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">18. 获取热门城市信息（返回 id 作为 city_id 使用）</td>
            <td><?php echo $domain?>/region/get_hot_region_data_list</td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/region/get_region_data_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">19. 获取城市信息（返回 id 作为 city_id 使用）</td>
            <td><?php echo $domain?>/region/get_region_data_list</td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/order/add_data" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">20. 首页 － 点击发车</td>
            <td><?php echo $domain?>/order/add_data</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td>（可选填）货主ID（shipper_id，请求 获取所有货运公司 接口会返回）</td>
            <td><input type="text" name="shipper_id" value="2"></td>
        </tr>
        <tr>
            <td>起点城市ID（start_city_id，请求 获取城市信息 接口获取，id）</td>
            <td><input type="text" name="start_city_id" value=""></td>
        </tr>
        <tr>
            <td>起点纬度（start_lat）</td>
            <td><input type="text" name="start_lat" value=""></td>
        </tr>
        <tr>
            <td>起点经度（start_lng）</td>
            <td><input type="text" name="start_lng" value=""></td>
        </tr>
        <!-- <tr>
            <td>起点详细地址（start_location）</td>
            <td><input type="text" name="start_location" value=""></td>
        </tr> -->
        <tr>
            <td>终点城市ID（end_city_id，请求 获取城市信息 接口获取，id）</td>
            <td><input type="text" name="end_city_id" value=""></td>
        </tr>
        <tr>
            <td>终点纬度（end_lat）</td>
            <td><input type="text" name="end_lat" value=""></td>
        </tr>
        <tr>
            <td>终点经度（end_lng）</td>
            <td><input type="text" name="end_lng" value=""></td>
        </tr>
        <!-- <tr>
            <td>终点详细地址（end_location）</td>
            <td><input type="text" name="end_location" value=""></td>
        </tr> -->
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver_anomaly" method="post" enctype="multipart/form-data">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">21. 上报异常（post）</td>
            <td><?php echo $domain?>/driver_anomaly</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td>订单ID（order_id）</td>
            <td><input type="text" name="order_id" value="255"></td>
        </tr>
        <tr>
            <td>异常文字描述（exce_desc）</td>
            <td><textarea name="exce_desc">前方看见美女</textarea></td>
        </tr>
        <tr>
            <td>纬度（latitude）</td>
            <td><input type="text" name="latitude" value=""></td>
        </tr>
        <tr>
            <td>经度（longitude）</td>
            <td><input type="text" name="longitude" value=""></td>
        </tr>
        <tr>
            <td>省份名称（province_name）</td>
            <td><input type="text" name="province_name" value=""></td>
        </tr>
        <tr>
            <td>城市名称（city_name）</td>
            <td><input type="text" name="city_name" value=""></td>
        </tr>
        <tr>
            <td>设备（device）</td>
            <td><input type="text" name="device" value=""></td>
        </tr>
        <tr>
            <td>时速（speedInKPH）</td>
            <td><input type="text" name="speedInKPH" value=""></td>
        </tr>
        <tr>
            <td>方向（heading）</td>
            <td><input type="text" name="heading" value=""></td>
        </tr>
        <tr>
            <td>图片1（anomaly_file_1）：</td>
            <td><input type="file" name="anomaly_file_1"></td>
        </tr>
        <tr>
            <td>图片2（anomaly_file_2）：</td>
            <td><input type="file" name="anomaly_file_2"></td>
        </tr>
        <tr>
            <td>图片3（anomaly_file_3）：</td>
            <td><input type="file" name="anomaly_file_3"></td>
        </tr>
        <tr>
            <td>图片4（anomaly_file_4）：</td>
            <td><input type="file" name="anomaly_file_4"></td>
        </tr>
        <tr>
            <td>图片5（anomaly_file_5）：</td>
            <td><input type="file" name="anomaly_file_5"></td>
        </tr>
        <tr>
            <td>图片6（anomaly_file_6）：</td>
            <td><input type="file" name="anomaly_file_6"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/xing_message/send_driver_message" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">22. 发送广播（供测试使用）</td>
            <td><?php echo $domain?>/xing_message/send_driver_message</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td>title</td>
            <td>public_driver_message</td>
        </tr>
        <tr>
            <td>内容（content）</td>
            <td><textarea name="content">标题|内容内容内容</textarea></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/xing_message/get_driver_message" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">23. 获取广播</td>
            <td><?php echo $domain?>/xing_message/get_driver_message</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/xing_message/delete_all_driver_message" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">24. 清空广播</td>
            <td><?php echo $domain?>/xing_message/delete_all_driver_message</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="9"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/order/finished_order" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">25. 距离目的地50公里，上报公司，订单完成</td>
            <td><?php echo $domain?>/order/finished_order</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="11"></td>
        </tr>
        <tr>
            <td>订单ID（order_id）</td>
            <td><input type="text" name="order_id" value="274"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/tracking/add_data" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">26. 上传 tracking</td>
            <td><?php echo $domain?>/tracking/add_data</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="7"></td>
        </tr>
        <tr>
            <td>车辆ID（vehicle_id, 没有传0）</td>
            <td><input type="text" name="vehicle_id" value="8"></td>
        </tr>
        <tr>
            <td>纬度（latitude）</td>
            <td><input type="text" name="latitude" value="30.807735"></td>
        </tr>
        <tr>
            <td>经度（longitude）</td>
            <td><input type="text" name="longitude" value="104.142485"></td>
        </tr>
        <tr>
            <td>省份名称（province_name）</td>
            <td><input type="text" name="province_name" value="四川省"></td>
        </tr>
        <tr>
            <td>城市名称（city_name）</td>
            <td><input type="text" name="city_name" value="成都市"></td>
        </tr>
        <tr>
            <td>设备（device）</td>
            <td><input type="text" name="device" value="869275016258368"></td>
        </tr>
        <tr>
            <td>时速（speedInKPH）</td>
            <td><input type="text" name="speedInKPH" value="0"></td>
        </tr>
        <tr>
            <td>方向（heading）</td>
            <td><input type="text" name="heading" value="359"></td>
        </tr>
        <tr>
            <td>上报方式（provider）</td>
            <td>
                <select name="provider">
                    <option value="net">net</option>
                    <option value="gps">gps</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/order/deleted_order" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">27. 取消订单</td>
            <td><?php echo $domain?>/order/deleted_order</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="11"></td>
        </tr>
        <tr>
            <td>订单ID（order_id）</td>
            <td><input type="text" name="order_id" value="274"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/driver_join_company" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">28. 加入货运公司</td>
            <td><?php echo $domain?>/driver/driver_join_company</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="11"></td>
        </tr>
        <tr>
            <td>货运公司ID（company_id）</td>
            <td><input type="text" name="company_id" value="1"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/driver_quit_company" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">29. 退出货运公司</td>
            <td><?php echo $domain?>/driver/driver_quit_company</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="11"></td>
        </tr>
        <tr>
            <td>货运公司ID（company_id）</td>
            <td><input type="text" name="company_id" value="1"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/vehicle/get_vehicle_by_driver_id" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">30. 获取车辆信息</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_by_driver_id</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="11"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/update_app_add_score" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">31. 成功更新APP增加积分</td>
            <td><?php echo $domain?>/driver/update_app_add_score</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="49"></td>
        </tr>
        <tr>
            <td>升级之后的设备号（device）</td>
            <td><input type="text" name="device" value="2"></td>
        </tr>
        <tr>
            <td>升级之前的版本号（pre_version）</td>
            <td><input type="text" name="pre_version" value="1.1"></td>
        </tr>
        <tr>
            <td>升级之后的版本号（version）</td>
            <td><input type="text" name="version" value="1.2"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/get_invite_url" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">32. 获取司机的邀请链接</td>
            <td><?php echo $domain?>/driver/get_invite_url</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="11"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/update_device" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">33. 更新司机设备号</td>
            <td><?php echo $domain?>/driver/update_device</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="4"></td>
        </tr>
        <tr>
            <td>设备号（device）</td>
            <td><input type="text" name="device" value="4"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/get_driver_score_history" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">34. 好运币明细</td>
            <td><?php echo $domain?>/driver/get_driver_score_history</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="49"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/product_score/" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">35. APP 端积分商品</td>
            <td><?php echo $domain?>/product_score/</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="49"></td>
        </tr>
        <tr>
            <td>类型（exchange_type，APP端默认 1）</td>
            <td>
                <select name="exchange_type">
                    <option value="1" selected>司机</option>
                    <option value="2">货运公司</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/exchange_product_score" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">36. 兑换积分商品</td>
            <td><?php echo $domain?>/driver/exchange_product_score</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="49"></td>
        </tr>
        <tr>
            <td>积分商品ID（id，请求 35 接口获取积分商品 ID）</td>
            <td><input type="text" name="id" value="1"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/exchange_log" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">37. 兑换记录</td>
            <td><?php echo $domain?>/driver/exchange_log</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="49"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/driver/get_company_stat" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">38. 我的公司</td>
            <td><?php echo $domain?>/driver/get_company_stat</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="49"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/app_conf/get_score_rule_text" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">39. 获取积分规则</td>
            <td><?php echo $domain?>/app_conf/get_score_rule_text</td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/region/get_province_data_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">40. 获取所有省份</td>
            <td><?php echo $domain?>/region/get_province_data_list</td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/region/get_city_data_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">41. 获取城市</td>
            <td><?php echo $domain?>/region/get_city_data_list</td>
        </tr>
        <tr>
            <td>省份ID（province_id）</td>
            <td><input type="text" name="province_id" value="25"></td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/member/update_personal_info" method="post" enctype="multipart/form-data">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">42. 更新个人资料</td>
            <td><?php echo $domain?>/member/update_personal_info</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="49"></td>
        </tr>
        <tr>
            <td>头像（driver_head_icon）</td>
            <td><input type="file" id="driver_head_icon" name="driver_head_icon"></td>
        </tr>
        <tr>
            <td>名字（driver_name）</td>
            <td><input type="text" name="driver_name" value="张三"></td>
        </tr>
        <tr>
            <td>省份ID（driver_province）</td>
            <td><input type="text" name="driver_province" value="3"></td>
        </tr>
        <tr>
            <td>城市ID（driver_city）</td>
            <td><input type="text" name="driver_city" value="49"></td>
        </tr>
        <tr>
            <td>性别（driver_sex）</td>
            <td>
                <select name="driver_sex">
                    <option value="男">男</option>
                    <option value="女">女</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                查看json结果：
                <select name="n">
                    <option value="2">否</option>
                    <option value="1">是</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

</body>
</html>