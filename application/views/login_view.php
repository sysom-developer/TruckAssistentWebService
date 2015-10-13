<?php $this->load->view('header_view');?>

<link href="<?php echo static_url('static/css/land.css')?>" rel="stylesheet" />

<body style="margin:0px;padding:0px">

<div class="top">
    <div class="top_left">
        <div class="top_left_logo">
            <a href="<?php echo site_url()?>"><img src="<?php echo static_url('static/images/logo.png')?>"/></a> 
        </div>
    </div><!--top_left-->
    <div class="top_right">
        <div class="top_right_list">
            <ul>
                <li class="link_red"><a href="<?php echo site_url()?>">首页</a></li>
                <li><a href="<?php echo site_url('tube_car')?>">我要管车</a></li>
                <li><a href="<?php echo site_url('join_team')?>">加入车队</a></li>
                <li><a href="<?php echo site_url('help')?>">产品帮助</a></li>
                <li><a href="<?php echo site_url('attention')?>">关注我们</a></li>
            </ul>
        </div>
    </div><!--top_right-->
</div><!--top-->

<div class="land" >
    <div class="title">
        <h2>账号登陆</h2>
    </div>
    <div class="account">
        <div class="account_text">
            <div>账号&nbsp;&nbsp;<input type="text"></div>
        </div>
        <div class="account_line"><img src="<?php echo static_url('static/images/land_line.png')?>"/></div>
        <div class="password">
            <div>密码&nbsp;&nbsp;<input type="password"></div>
        </div>
    </div>
    <p>登陆</p>
    <ul>
        <li ><a href="<?php echo site_url('public_web_shipper/register')?>" >注册账号</a></li>
        <li><img src="<?php echo static_url('static/images/land_line_2.png')?>" /> </li>
        <li><a href="<?php echo site_url('forget_password')?>">忘记密码？</a></li>
    </ul>
</div><!--land-->

</body>

<?php $this->load->view('footer_view');?>