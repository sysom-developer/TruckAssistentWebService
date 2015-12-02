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

<br/><br/>
<form action="<?php echo $domain?>/waybill/get_waybill_list" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">1. 根据司机id获取运单列表(多个、单个) 历史运单｜ 历史运单</td>
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


<form action="<?php echo $domain?>/waybill/update_waybill_data" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">2. 修改运单信息</td>
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



<form action="<?php echo $domain?>/waybill/get_hot_city" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">4. 获取热门城市(配置文件)</td>
            <td><?php echo $domain?>/waybill/get_hot_city</td>
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

<form action="<?php echo $domain?>/waybill/get_history_city" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">5. 获取历史记录城市</td>
            <td><?php echo $domain?>/waybill/get_history_city</td>
        </tr>
        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
        </tr>
        <tr>
            <td>  个数（count）</td>
            <td><input type="text" name="count" value="2"></td>
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
            <td colspan="2">{"application":{"head":{{"code":"1799",&nbsp;&nbsp; "description":"count 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>
        <tr bgcolor="#ffe4c4">
            <td colspan="2">{"application":{"head":{{"code":"1798",&nbsp;&nbsp; "description":"driver_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>

        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>




<form action="<?php echo $domain?>/waybill/detail" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">6. 运单详情, 首页，历史运单 | 停留时间，运单，路段耗油，公里耗油停留</td>
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



<form action="<?php echo $domain?>/mileage/detail" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">7. 行程详情 首页｜ 轨迹详情（基本信息）</td>
            <td><?php echo $domain?>/mileage/detail</td>
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


<form action="<?php echo $domain?>/mileage/tracking" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">8. 轨迹详情 首页｜ 轨迹详情（坐标点）</td>
            <td><?php echo $domain?>/mileage/tracking</td>
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
            <td colspan="2">{"application":{"head":{{"code":"2198",&nbsp;&nbsp; "description":"mileage_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>



<form action="<?php echo $domain?>/mileage/speed_ratio" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">9. 轨迹速度比例 首页｜ 轨迹详情</td>
            <td><?php echo $domain?>/mileage/speed_ratio</td>
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
            <td colspan="2">{"application":{"head":{{"code":"2298",&nbsp;&nbsp; "description":"mileage_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>



<form action="<?php echo $domain?>/waybill/summary" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">10.  获取月份运单统计   历史运单｜ 历史运单,停留</td>
            <td><?php echo $domain?>/waybill/summary</td>
        </tr>
        <tr>
            <td>  时间差，0－当月，－1－上一月， －2-上2月（last_count）</td>
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
            <td colspan="2">{"application":{"head":{{"code":"2298",&nbsp;&nbsp; "description":"mileage_id 参数错误"}},&nbsp;&nbsp; "body":[]}</td>
        </tr>


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


</body>
</html>
