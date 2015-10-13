<div class="top_bg">
    <div class="top">
        <div class="top_left">
            <div class="top_left_logo" style="margin-top:7.5px;">
                <a href="<?php echo site_url()?>"><img src="<?php echo static_url('static/images/logo.png')?>"/></a> 
            </div>
        </div><!--top_left-->
        <div class="top_right">
            <div class="top_right_list">
                <ul>
                    <li><a href="<?php echo site_url()?>" <?php if ($this->router->fetch_class() == 'main') { echo 'style="color: red;"';}?>>首页</a></li>
                    <li><a href="<?php echo site_url('tube_car')?>" <?php if ($this->router->fetch_class() == 'tube_car') { echo 'style="color: red;"';}?>>我要管车</a></li>
                    <li><a href="<?php echo site_url('join_team')?>" <?php if ($this->router->fetch_class() == 'join_team') { echo 'style="color: red;"';}?>>加入车队</a></li>
                    <li><a href="<?php echo site_url('help')?>" <?php if ($this->router->fetch_class() == 'help') { echo 'style="color: red;"';}?>>产品帮助</a></li>
                    <li><a href="<?php echo site_url('attention')?>" <?php if ($this->router->fetch_class() == 'attention') { echo 'style="color: red;"';}?>>关注我们</a></li>
                </ul>
            </div><!--top_right_list-->
            <div class="top_right_land">
                <ul>
                    <li><a href="<?php echo site_url('public_web_shipper/register')?>">注册</a></li>
                    <li><a href="<?php echo site_url('public_web_shipper/login')?>">登录</a></li>
                </ul>
            </div>
        </div><!--top_right-->
    </div><!--top-->
</div><!--top_bg-->