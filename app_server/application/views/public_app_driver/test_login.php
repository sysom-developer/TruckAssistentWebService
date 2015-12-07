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
    case 'testing':
        $domain = 'http://local.newtuhaoyun.com/'.$this->appfolder;
        break;
    case 'production':
        $domain = 'http://www.tuhaoyun.com.cn/'.$this->appfolder;
        break;
    default:
        exit('999');
}
?>

<p>
    <a href="<?php echo $domain;?>/test_interface">主菜单</a>
</p>
<p>
    <a href="<?php echo $domain;?>/test_interface/login">登录模块接口</a>
</p>

<p>
    <a href="<?php echo $domain;?>/test_interface/waybill">运单模块接口</a>
</p>


<p>
    <a href="<?php echo $domain;?>/test_interface/ranking">排行榜模块接口</a>
</p>


<p>
    <a href="<?php echo $domain;?>/test_interface/my">我的</a>
</p>

<br/><br/>

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
            <td colspan="2">输入信息 </td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"mobile_phone":"13427591775"}</td>
        </tr>

        <tr>
            <td colspan="2">返回结果</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1099",&nbsp;&nbsp; "description":"手机号码输入错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1098",&nbsp;&nbsp; "description":"验证码发送失败"}},&nbsp;&nbsp; "body":[]}</td>
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
            <td colspan="2">输入信息 </td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"mobile_phone":"13427591775", "password":"xxxx", "seccode":"3456", "device":"ff379ksh"}</td>
        </tr>

        <tr>
            <td colspan="2">返回结果</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1199",&nbsp;&nbsp; "description":"验证码不存在"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1198",&nbsp;&nbsp; "description":"验证码失效"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1197",&nbsp;&nbsp; "description":"请正确输入手机号码"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1196",&nbsp;&nbsp; "description":"请输入6位或以上的密码"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1195",&nbsp;&nbsp; "description":"请重新操作"}},&nbsp;&nbsp; "body":[]}device为空</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1194",&nbsp;&nbsp; "description":"手机号码已经存在"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1193",&nbsp;&nbsp; "description":"司机信息写入失败"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1192",&nbsp;&nbsp; "description":"车辆信息写入失败"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1191",&nbsp;&nbsp; "description":"操作失败"}},&nbsp;&nbsp; "body":[]}数据库错误</td>
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
            <td colspan="2">输入信息 </td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"mobile_phone":"13427591775", "password":"xxxx", "device":"3ggft45uy6", "model":"ff379ksh", "version":"k43jk89"}</td>
        </tr>

        <tr>
            <td colspan="2">返回结果</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":{"user": {
                "driver_id": "1",
                "driver_name": "13823456789",
                "login_name": "13823456789",
                "login_pwd": "123456",
                "driver_nick_name": "13823456789",
                "driver_sex": "ç”·",
                "driver_province": "0",
                "driver_city": null,
                "driver_mobile": "13823456789",
                "driver_tel": "",
                "driver_card_num": "",
                "driver_license": "",
                "driver_head_icon": false,
                "driver_card_icon": false,
                "driver_license_icon": false,
                "driver_vehicle_license_icon": false,
                "driver_pic": false,
                "device": "3321321",
                "create_time": "1445346788",
                "remark": "",
                "is_vehicle_perfect": "0"
                }}}
                <br>
                <span style="color: #0000FF">其中，is_vehicle_perfect未车辆信息是否完善，0为否，需要弹出完善信息，1为是，表示信息已完善</span>
            </td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1299",&nbsp;&nbsp; "description":"请正确输入手机号码"}},&nbsp;&nbsp; "body":[]}手机号码格式错误</td>
        </tr>

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1298",&nbsp;&nbsp; "description":"请输入6位或以上的密码"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1297",&nbsp;&nbsp; "description":"手机号码输入错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1296",&nbsp;&nbsp; "description":"密码输入错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1295",&nbsp;&nbsp; "description":"操作失败"}},&nbsp;&nbsp; "body":[]}数据库错误</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/vehicle/get_vehicle_type" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">4. 获取车辆类型－－采用配置文件</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_type</td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">直接点击提交查看</td>
        </tr>

        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/vehicle/get_vehicle_load" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">5. 获取车辆载重－－采用配置文件</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_load</td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">直接点击提交查看</td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/vehicle/get_vehicle_length" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">6. 获取车辆长度－－采用配置文件</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_length</td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">直接点击提交查看</td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


<form action="<?php echo $domain?>/vehicle/get_vehicle_rear_axle_ratio" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">7. 获取车辆后桥速比－－采用配置文件</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_rear_axle_ratio</td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">直接点击提交查看</td>
        </tr>
        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/member/update_info" method="post" enctype="multipart/form-data">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">8. 更新车辆资料</td>
            <td><?php echo $domain?>/member/update_info</td>
        </tr>
        <tr>
            <td>司机ID（driver_id）</td>
            <td><input type="text" name="driver_id" value="1"></td>
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
            <td>后桥速比（rear_axle_ratio）</td>
            <td><input type="text" name="rear_axle_ratio" value="3"></td>
        </tr>
        <tr>
            <td>odb设备号（obd_device_no）</td>
            <td><input type="text" name="obd_device_no" value="3fdslkfdsfhk"></td>
        </tr>


        <tr>
            <td>车辆品牌（vehicle_brand）</td>
            <td><input type="text" name="vehicle_brand" value="3fdslkfdsfhk"></td>
        </tr>
        <tr>
            <td>获取车辆型号（obd_device_no）</td>
            <td><input type="text" name="vehicle_model" value="3fdslkfdsfhk"></td>
        </tr>
        <tr>
            <td>发动机品牌（engine_brand）</td>
            <td><input type="text" name="engine_brand" value="3fdslkfdsfhk"></td>
        </tr>
        <tr>
            <td>发动机排量（engine_displacement）</td>
            <td><input type="text" name="engine_displacement" value="3fdslkfdsfhk"></td>
        </tr>



<!--        <tr>-->
<!--            <td>驾驶证照片（driver_license_icon）</td>-->
<!--            <td><input type="file" name="driver_license_icon"></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>行驶证照片（driver_vehicle_license_icon）</td>-->
<!--            <td><input type="file" name="driver_vehicle_license_icon"></td>-->
<!--        </tr>-->
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
            <td colspan="2">输入信息 </td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"driver_id":"1","vehicle_card_num":"皖BY7881", "vehicle_type":"1", "vehicle_load":"3", "vehicle_length":"2", "obd_device_no":"k436376bdf8"}</td>
        </tr>

        <tr>
            <td colspan="2">返回结果</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1399",&nbsp;&nbsp; "description":"driver_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1397",&nbsp;&nbsp; "description":"请选择车辆类型"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1396",&nbsp;&nbsp; "description":"请选择车辆载重"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1395",&nbsp;&nbsp; "description":"请选择车辆长度"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1394",&nbsp;&nbsp; "description":"请选择车辆后桥速比"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


<form action="<?php echo $domain?>/member/update_personal_info" method="post" enctype="multipart/form-data">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">9. 更新个人资料</td>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1899",&nbsp;&nbsp; "description":"driver_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1898",&nbsp;&nbsp; "description":"名字不可为空"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1897",&nbsp;&nbsp; "description":"性别错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1396",&nbsp;&nbsp; "description":"操作失败"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

    </table>
</form>

</body>
</html>
