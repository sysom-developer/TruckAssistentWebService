<?php $this->load->view($this->appfolder.'/header_view')?>

<style type="text/css">
body{background: #054372;}
</style>

<script type="text/javascript">
$(function() {
	var winWidth  = $(window).width();
	var winHeight = $(window).height();
	if(winWidth < 1000) winWidth = 1000;
	
	$("#warrper").css("height",winHeight - 126);

	var seccode_path = "<?php echo site_url('"+appfolder+"/secode')?>";
	$("#seccode").click(function() {
		$(this).prop("src", seccode_path+"/?y="+Math.random());
	});
});
</script>

<div class="header">
	<div class="header_content">
    	<div class="logo"></div>
        <div class="shop">
            <div class="rows">
            	<span class="company"><?php echo $title?></span>
            </div>
        </div>
    </div>
</div>

<div class="warrper" id="warrper">
	<div class="login_holder">
		<h3><?php echo $title?></h3>
		<form name="login_form" action="<?php echo site_url(''.$this->appfolder.'/login/act_login')?>" method="post">
		<div class="login_box">
			<p><label>用户名：</label><input type="text" class="txt" name="username" value="" /></p>
			<p><label>密 码：</label><input type="password" class="txt" name="password" value="" /></p>
			<p><label>验证码：</label><input type="text" class="valid" name="seccodeverify" value="" /><img id="seccode" style="cursor:pointer;" src="<?php echo site_url(''.$this->appfolder.'/secode/?y='.mt_rand(0, 1000).'')?>" width="100" height="30" /></p>
			<p><input type="submit" class="btn" value="登 录" /><input type="button" class="btn" value="重 置" /></p>
		</div>
		</form>
	</div>
</div>

<?php $this->load->view($this->appfolder.'/footer_view')?>
