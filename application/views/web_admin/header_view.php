<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title?></title>
<link rel="Bookmark" href="<?php echo static_url('favicon.ico')?>"/>
<link rel="shortcut icon" href="<?php echo static_url('favicon.ico')?>" type="image/x-icon">
<link rel="icon" href="<?php echo static_url('favicon.ico')?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/system.css')?>" /> 
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.js')?>"></script>
<script type="text/javascript">
var appfolder = '<?php echo $this->appfolder?>';
var apppath = '<?php echo site_url("'+appfolder+'")?>/';
var fetch_class = '<?php echo $this->router->fetch_class()?>';
var fetch_method = '<?php echo $this->router->fetch_method()?>';
$(function() {
	$("input[class='btn']").each(function(){
		$(this).hover(
			function(){
				$(this).prop("class","btn_on");
			},
			function(){
				$(this).prop("class","btn");
			}
		);
	});
});
</script>
</head>

<body>