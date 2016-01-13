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
<form action="<?php echo $domain?>/my/index" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">1. 根据司机id获取自己资料</td>
            <td><?php echo $domain?>/my/index</td>
        </tr>


        <tr>
            <td> 司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


<form action="<?php echo $domain?>/my/update_head_icon" method="post" enctype="multipart/form-data">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">2. 更换头像</td>
            <td><?php echo $domain?>/my/update_head_icon</td>
        </tr>

        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
        </tr>

        <tr>
            <td>头像（driver_head_icon）</td>
            <td><input type="file" id="driver_head_icon" name="driver_head_icon"></td>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


<form action="<?php echo $domain?>/my/update_nick_name" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">3. 修改昵称</td>
            <td><?php echo $domain?>/my/update_nick_name</td>
        </tr>

        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
        </tr>

        <tr>
            <td>昵称（driver_nick_name）</td>
            <td><input type="text"  name="driver_nick_name"></td>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


<form action="<?php echo $domain?>/vehicle/get_vehicle_brand" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">4. 获取车辆品牌－－采用配置文件</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_brand</td>
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


<form action="<?php echo $domain?>/vehicle/get_vehicle_model" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">5. 获取车辆型号－－采用配置文件</td>
            <td><?php echo $domain?>/vehicle/get_vehicle_model</td>
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



<form action="<?php echo $domain?>/vehicle/get_engine_brand_displacement" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">6. 根据车辆品牌获取发动机品牌和排量－－采用配置文件</td>
            <td><?php echo $domain?>/vehicle/get_engine_brand_displacement</td>
        </tr>
        <tr>
            <td>车辆品牌id（vehicle_brand_id）</td>
            <td><input type="text"  name="vehicle_brand_id"></td>
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


<form action="<?php echo $domain?>/device/get_device_information" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">8. 根据司机id获取设备信息</td>
            <td><?php echo $domain?>/device/get_device_information</td>
        </tr>
        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
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


<form action="<?php echo $domain?>/device/relieve_device" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">9. 解除绑定</td>
            <td><?php echo $domain?>/device/relieve_device</td>
        </tr>

        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
        </tr>

        <tr>
            <td>  obd设备号（obd_device_no）</td>
            <td><input type="text" name="obd_device_no" value="2"></td>
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



<form action="<?php echo $domain?>/message/index" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">10. 消息中心｜ 根据司机id获取消息列表</td>
            <td><?php echo $domain?>/message/index</td>
        </tr>
        <tr>
            <td>司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
        </tr>

        <tr>
            <td> 起始（offset）</td>
            <td><input type="text" name="offset" value="0"></td>
        </tr>
        <tr>
            <td> 查询数量（limit）</td>
            <td><input type="text" name="limit" value="3"></td>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>



<form action="<?php echo $domain?>/message/detail" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">11. 消息中心｜ 根据消息id获取消息详情</td>
            <td><?php echo $domain?>/message/detail</td>
        </tr>
        <tr>
            <td>消息id（message_id）</td>
            <td><input type="text" name="message_id" value="2"></td>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

<form action="<?php echo $domain?>/message/del" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">12. 消息中心｜ 根据消息id删除消息</td>
            <td><?php echo $domain?>/message/del</td>
        </tr>
        <tr>
            <td>消息id列表（message_id_list）</td>
            <td><input type="text" name="message_id_list" value="2,3,4"></td>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>




<form action="<?php echo $domain?>/device/relieve_device" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">13. 修改密码</td>
            <td><?php echo $domain?>/my/update_pwd</td>
        </tr>

        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
        </tr>

        <tr>
            <td>  旧密码（origin_pwd）</td>
            <td><input type="password" name="origin_pwd" value="123456"></td>
        </tr>

        <tr>
            <td>  新密码（new_pwd）</td>
            <td><input type="password" name="new_pwd" value="123456"></td>
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



<form action="<?php echo $domain?>/message/pull_message" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">14. 获取推送消息</td>
            <td><?php echo $domain?>/message/pull_message</td>
        </tr>
        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>

</body>
</html>
