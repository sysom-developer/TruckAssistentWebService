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
<form action="<?php echo $domain?>/ranking/index" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">1. 获取排行榜司机列表(多个)</td>
            <td><?php echo $domain?>/ranking/index</td>
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
            <td>  类型（type）</td>

            <td>
                <select name="type">
                    <option value="driving_mileage">驾驶里程</option>
                    <option value="consumption_per_100km">百里油耗</option>
                </select>
            </td>

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


<form action="<?php echo $domain?>/ranking/detail" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">2. 获取司机详细排行信息</td>
            <td><?php echo $domain?>/ranking/detail</td>
        </tr>


        <tr>
            <td>  类型（type）</td>

            <td>
                <select name="type">
                    <option value="driving_mileage">驾驶里程</option>
                    <option value="consumption_per_100km">百里油耗</option>
                </select>
            </td>

        </tr>


        <tr>
            <td>  司机id（driver_id）</td>
            <td><input type="text" name="driver_id" value="2"></td>
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


        <tr>
            <td colspan="2"><hr style="border:1px dashed #000; height:1px"></td>
        </tr>
    </table>
</form>


<form action="<?php echo $domain?>/friend/follow" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">3. 添加关注</td>
            <td><?php echo $domain?>/friend/follow</td>
        </tr>


        <tr>
            <td>  被关注者id（followed_driver_id）</td>
            <td><input type="text" name="followed_driver_id" value="3"></td>
        </tr>


        <tr>
            <td>  关注者id（follower_driver_id）</td>
            <td><input type="text" name="follower_driver_id" value="2"></td>
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
