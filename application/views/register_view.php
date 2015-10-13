<?php $this->load->view('header_view');?>

<link href="<?php echo static_url('static/css/registered.css')?>" rel="stylesheet" />

<body>

<div class="top">
    <div class="top_left">
        <div class="top_left_logo">
            <a href="<?php echo site_url()?>"><img src="<?php echo static_url('static/images/logo.png')?>"/></a>
        </div>
    </div><!--top_left-->
    <div class="top_right">
        <div class="top_right_list">
            <ul>
                <li><a href="<?php echo site_url()?>">首页</a></li>
                <li><a href="<?php echo site_url('tube_car')?>">我要管车</a></li>
                <li><a href="<?php echo site_url('join_team')?>">加入车队</a></li>
                <li><a href="<?php echo site_url('help')?>">产品帮助</a></li>
                <li><a href="<?php echo site_url('attention')?>">关注我们</a></li>
            </ul>
        </div>
    </div><!--top_right-->
</div><!--top-->

<div class="registered">
    <div class="registered_top">
        <div class="registered_top_left">
            <h1>请选择货主注册类型</h1>
        </div>
        <div class="registered_top_right">
            <ul>
                <li>
                    <a href="<?php echo site_url('public_web_shipper/login')?>">马上登录</a>
                </li>
                <li>已有账号？</li>
            </ul>
        </div>
    </div>
    <div class="registered_fill">
        <div class="registered_fill_top">
            <ul>
                <li>                            
                    <a href="#"><img src="<?php echo static_url('static/images/registered_radio.png')?>" /></a>
                    <p>新注册用户</p>
                </li>
                <li>                            
                    <a href="#"><img src="<?php echo static_url('static/images/registered_radio_red.png')?>"/></a>
                    <p>已注册公司用户</p>
                </li>
            </ul>
        </div>
        <div class="registered_fill_line"></div>
        <div class="registered_fill_in">
            <div class="in_from">
                <ul class="in_from_text">
                    <li><p>账号</p></li>
                    <li><p>验证码</p></li>
                    <li><p>设置密码</p></li>
                    <li><p>确认密码</p></li>
                </ul>
                <ul class="in_from_inptu">
                    <li><input type="text" name="account"></li>
                    <li id="obtain"><input type="text" name="verification"></li>
                    <li><input type="password"name="set"></li>
                    <li><input type="password"name="confirm"></li>
                </ul>
                <a href="#">获取验证码</a>
            </div>
            <div class="registered_fill_line_two"></div>
            <div class="in_from_bottom">
                <ul class="from_bottom_text">
                    <li><p>公司名称</p></li>
                    <li><p>公司地址</p></li>
                </ul>
                <ul class="from_bottom_input">
                    <li><input type="text" name="company"></li>
                    <li><input type="text" name="address"></li>
                </ul>
            </div>
        </div>
        <div class="registered_fill_bottom">
            <from>
                <input type="checkbox" name="Agreement">
                <p>我已阅读并同意《<a href="#">软件许可及服务协议</a>》</p>
            </from>
        </div>
    </div>
    <div class="registered_bottom">
        <a href="#">注册</a>
    </div>
</div><!--registered-->
<div class="bottom">
    <p>copyright@2015&nbsp;&nbsp;上海麦素物联网科技有限公司&nbsp;&nbsp;京ICP备12345678号</p>
</div>

</body>

<?php $this->load->view('footer_view');?>