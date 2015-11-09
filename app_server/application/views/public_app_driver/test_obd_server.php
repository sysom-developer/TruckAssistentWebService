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

<br/><br/>
<form action="<?php echo $domain?>/test_TCP" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">1. 开机启动</td>
            <td><?php echo $domain?>/test_TCP</td>
        </tr>
        <tr>
            <td>数据包 （data）</td>
            <td><input type="text" name="data" value="2"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
    </table>
</form>

<br/><br/>
<form action="<?php echo $domain?>/test_TCP/get_socket" method="get">
    <table style="margin-left: 30px;" width="100%">
        <tr style="font-weight: bold; font-size: 14px;">
            <td width="300">2.  获取socket</td>
            <td><?php echo $domain?>/test_TCP/get_socket</td>
        </tr>
        <tr>
            <td>数据包 （session_id）</td>
            <td><input type="text" name="session_id" value="2"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="提 交"></td>
        </tr>
    </table>
</form>

</body>
</html>