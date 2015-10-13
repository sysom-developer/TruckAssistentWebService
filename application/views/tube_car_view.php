<?php $this->load->view('header_view');?>

<link href="<?php echo static_url('static/css/homepage.css')?>" rel="stylesheet" type="text/css"/>    
<link href="<?php echo static_url('static/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo static_url('static/js/jquery-2.1.4.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/bootstrap.min.js');?>" type="text/javascript"></script>

<body>

<?php $this->load->view('top_menu_view');?>
                                    
<div class="item">
    <img src="<?php echo static_url('static/images/tube_bg.png')?>" alt="" style="width: 100%;height: 579px;">                     
        <div class="carousel_right">
            <ul class="qrcode">
                <li><h2>透明运输全程可控<br/>减息贷款，被赊帐不慌<br/>做最省心的货老板</h2></li>
            </ul>
            <ul class="app tube_app">
                <li><a href="<?php echo site_url('public_web_shipper/register')?>">注册途好运货老板</a></li>
                <li><a href="<?php echo site_url('appdownload/TruckManager-release.apk')?>">下载途好运司机App</a></li>
            </ul>
        </div><!--carousel_two_right-->
</div><!--item-->               

<div class="content_one">
    <div class="content_one_left">
        <img src="<?php echo static_url('static/images/tube_img_1.png')?>"/> 
    </div>
    <div class="content_one_right">
        <h2>做最省心的货老板</h2>
        <h3>透明运输   全程可控</h3>
        <p>拉货的车跑到哪里了，走的哪条路，路上有没有堵，车有没有坏
            一目了然。天气预报说有雨，给司机发个通知，叮嘱提前盖好雨
            布。开发新货源，流动资金不足，也可以找途好运。
        </p>
    </div>
</div><!--content_one-->

<div class="content_two">
    <div class="content_one_right" style="float:left;margin-left:80px;">
        <h2>运输轨迹  一目了然</h2>
        <h3>&nbsp;</h3>
        <p>司机一发车，货老板在家就能看车的轨迹；司机上报路上遇到的堵车
            大雨、路政罚款等给公司，货老板统统能接到通知；司机完成，货就
            到目的地了。客户也能用运单号来查询车辆位置
        </p>
    </div>
    <div class="content_two_right"style="margin-top:25px">
        <img src="<?php echo static_url('static/images/tube_img_2.png')?>" /> 
    </div>
</div><!--content_two-->

<div class="content_tree">
    <img src="<?php echo static_url('static/images/tube_img_3.png')?>" />
</div><!--content_tree-->

<?php $this->load->view('text_bottom_view');?>

</body>

<?php $this->load->view('footer_view');?>