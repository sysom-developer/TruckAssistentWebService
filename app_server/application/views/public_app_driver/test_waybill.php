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


<form action="<?php echo $domain?>/waybill/index" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">1.首页 | 运单,停留时间,路段耗油,公里耗油停留</td>
            <td><?php echo $domain?>/waybill/index</td>
        </tr>
        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
        </tr>

        <tr>
            <td>  类型（type）</td>
            <td>
                <select name="type">
                    <option value="2">2停留</option>
                    <option value="1">1运单</option>
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

        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"E000000000",&nbsp;&nbsp; "description":"success"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">base.type 1-运单，2-停留</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">base.stay_time 停留时间，以秒为单位</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>





<form action="<?php echo $domain?>/mileage/index" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">2. 轨迹 首页｜ 轨迹详情（基本信息，坐标点， 速度比例）</td>
            <td><?php echo $domain?>/mileage/index</td>
        </tr>
        <tr>
            <td>  行程id（mileage_id）</td>
            <td><input type="text" name="mileage_id" value="2"></td>
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
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"2099",&nbsp;&nbsp; "description":"mileage_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>



<form action="<?php echo $domain?>/waybill/get_destination_city" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">3. 选择运单终点</td>
            <td><?php echo $domain?>/waybill/get_destination_city</td>
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

<form action="<?php echo $domain?>/waybill/update_waybill_data" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">4. 修改运单终点</td>
            <td><?php echo $domain?>/waybill/update_waybill_data</td>
        </tr>
        <tr>
            <td>运单id（waybill_id）</td>
            <td><input type="text" name="waybill_id" value="2"></td>
        </tr>
        <tr>
            <td>终点城市（end_city_id）</td>
            <td><input type="text" name="end_city_id" value="5"></td>
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
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1699",&nbsp;&nbsp; "description":"waybill_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1698",&nbsp;&nbsp; "description":"end_city_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>




<p> 5,6,7为耗油因子</p>





<form action="<?php echo $domain?>/waybill/get_waybill_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">8. 历史运单｜ 历史运单</td>
            <td><?php echo $domain?>/waybill/get_waybill_list</td>
        </tr>
        <tr>
            <td>司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
        </tr>
        <tr>
            <td>类型（type）1--运单，2--停留</td>
            <td><input type="text" name="type" value="1"></td>
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
            <td>  排序（order）</td>
            <td><input type="text" name="order" value="create_time"></td>
        </tr>
        <tr>
            <td>  排序（by）</td>
            <td><input type="text" name="by" value="desc"></td>
        </tr>
        <tr>
            <td>  年（year）</td>
            <td><input type="text" name="year" value="2015"></td>
        </tr>
        <tr>
            <td>  月（month）</td>
            <td><input type="text" name="year" value="12"></td>
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
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1499",&nbsp;&nbsp; "description":"driver_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1498",&nbsp;&nbsp; "description":"offset 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1497",&nbsp;&nbsp; "description":"limit 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1496",&nbsp;&nbsp; "description":"by 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1495",&nbsp;&nbsp; "description":"type 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>





<form action="<?php echo $domain?>/waybill/detail" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">9. 历史运单 | 运单详情</td>
            <td><?php echo $domain?>/waybill/detail</td>
        </tr>
        <tr>
            <td>  运单id（waybill_id）</td>
            <td><input type="text" name="waybill_id" value="2"></td>
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
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1899",&nbsp;&nbsp; "description":"detail 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


<form action="<?php echo $domain?>/waybill/get_tracking" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">10. 首页 | 运单轨迹</td>
            <td><?php echo $domain?>/waybill/get_tracking</td>
        </tr>
        <tr>
            <td>  运单id（waybill_id）</td>
            <td><input type="text" name="waybill_id" value="2"></td>
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
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1899",&nbsp;&nbsp; "description":"detail 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>



<form action="<?php echo $domain?>/waybill/get_consumption_factor" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">11. 首页 | 获取所有油耗因子</td>
            <td><?php echo $domain?>/waybill/get_consumption_factor</td>
        </tr>

        <tr>
            <td>  运单id（waybill_id）</td>
            <td><input type="text" name="waybill_id" value="2"></td>
        </tr>

        <tr>
            <td>  行程id（mileage_id）</td>
            <td><input type="text" name="mileage_id" value="2"></td>
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
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1899",&nbsp;&nbsp; "description":"detail 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>



<form action="<?php echo $domain?>/waybill/get_consumption_analysis" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">12. 首页 | 油耗分析</td>
            <td><?php echo $domain?>/waybill/get_consumption_analysis</td>
        </tr>


        <tr>
            <td>  运单id（waybill_id）</td>
            <td><input type="text" name="waybill_id" value="2"></td>
        </tr>

        <tr>
            <td>  行程id（mileage_id）</td>
            <td><input type="text" name="mileage_id" value="2"></td>
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
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1899",&nbsp;&nbsp; "description":"detail 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


<form action="<?php echo $domain?>/waybill/depth_report" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">13. 首页 | 深度报告</td>
            <td><?php echo $domain?>/waybill/depth_report</td>
        </tr>


        <tr>
            <td>  运单id（waybill_id）</td>
            <td><input type="text" name="waybill_id" value="2"></td>
        </tr>

        <tr>
            <td>  行程id（mileage_id）</td>
            <td><input type="text" name="mileage_id" value="2"></td>
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
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1899",&nbsp;&nbsp; "description":"detail 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


</body>
</html>
