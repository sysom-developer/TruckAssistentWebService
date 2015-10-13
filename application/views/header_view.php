<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title.$site_name?></title>
<meta name="keywords" content="途好运，物流，互联网物流，智慧物流，车队，互联网车队，无车承运人，管车，管车宝，货运，干线，运输，互联网运输，透明运输" />
<meta name="Description" content="上海麦速物联网信息科技有限公司成立于2014年，由国内最早一批从事车联网解决方案的团队和物流专业人士组成。 聚焦通过互联网模式和车联网技术，整合个体货运车主资源，为车主提供专业化的调度、运营、在线支付、保险、购车、 团购、售后服务等为专线、第三方物流企业和货主等提供统一形象、信用担保、成本更低和更有保障的透明车队运输服务 同时也涉及专线、第三方物流企业、货主等内部供应链信息系统建设和服务。" />
<link rel="Bookmark" href="<?php echo static_url('favicon.ico')?>"/>
<link rel="shortcut icon" href="<?php echo static_url('favicon.ico')?>" type="image/x-icon">
<link rel="icon" href="<?php echo static_url('favicon.ico')?>" type="image/x-icon">
</head>

<script type="text/javascript">
var u = navigator.userAgent, app = navigator.appVersion;
var is_Android = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
var is_iOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
if (is_Android || is_iOS) {
    window.location.href = "<?php echo site_url('app_web')?>";
}

var fetch_class = '<?php echo $this->router->fetch_class()?>';
var fetch_method = '<?php echo $this->router->fetch_method()?>';
</script>