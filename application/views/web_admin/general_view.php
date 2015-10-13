<?php $this->load->view(''.$this->appfolder.'/header_view');?>
<style type="text/css">
body{background:#054372;}
</style>
<script type="text/javascript">
$(function() {
	var winWidth  = $(window).width();
	var winHeight = $(window).height();
	
	$("#content").css("width",winWidth - 246);
	$("#content").find("iframe").eq(0).prop("width",winWidth - 246);

	// 菜单 
	$("a[name=menu_a]").click(function() {
		$("li[name=menu_li]").removeAttr("class");
		$(this).parent("li[name=menu_li]").addClass("on");
	});
	$("li[name=menu_li]").click(function() {
		$("li[name=menu_li]").removeAttr("class");
		$(this).addClass("on");
		$("#iframe_content").prop("src", $(this).children("a[name=menu_a]").prop("href"));
	});

    // 选择语言
    $("#lang").change(function() {
        var lang = $(this).val();
        var url = "<?php echo site_url(''.$this->appfolder.'/general/index/?lang="+lang+"')?>";
        window.location.href = url;
    });
});

$(window).resize(function(){
	var resizeWidth  = $(window).width();
	var resizeHeight = $(window).height();
	$("#content").css("width",resizeWidth - 246);
	$("#content").find("iframe").eq(0).prop("width",resizeWidth - 246);
});
</script>

<div class="header">
	<div class="header_content">
    	<div class="logo"></div>
        <div class="shop">
            <div class="rows">
            	<span class="company"><?php echo $title?></span>
                <span class="user">
                    选择语言：
                    <select id="lang" name="lang">
                        <?php
                        foreach ($lang_type as $k => $v) {
                        ?>
                        <option value="<?php echo $k?>" <?php if ($lang == $k) { echo 'selected';}?>><?php echo $v?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <?php echo greeting(); echo $this->user_info['username']?>. <a href="<?php echo site_url(''.$this->appfolder.'/logout')?>">退出</a>
                </span>
            </div>
            <div class="navigation">
            	<ul>
                	<?php foreach ($navigation as $k => $v) {?>
                    <li <?php if ($current_navigation == $k) { echo 'class="on"'; }?>><a href="<?php echo site_url(''.$this->appfolder.'/general/index/'.$k.'')?>"><?php echo $v?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="warrper" style="position:absolute; top:85px; bottom:40px; width:100%;">
	<div class="menu_box" id="menu_box" style="height:100%;">
    	<ul>
    		<?php foreach ($menu[$current_navigation] as $k => $v) {?>
        	<li name="menu_li" <?php if ($k == 1) { echo 'class="on"';}?>><a name="menu_a" href="<?php echo site_url(''.$this->appfolder.'/'.$v['controller_name'].'')?>" target="iframe_content"><?php echo $v['menu_name']?></a></li>
        	<?php }?>
        </ul>
    </div>
    <div class="content" id="content" style="position:absolute; left:245px; right:0px; height:100%;">
		<iframe id="iframe_content" name="iframe_content" src="<?php echo site_url(''.$this->appfolder.'/'.$menu[$current_navigation][1]['controller_name'].'')?>" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe>
    </div>
</div>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>