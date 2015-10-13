<?php $this->load->view('header_view');?>

<link href="<?php echo static_url('static/css/homepage.css')?>" rel="stylesheet" type="text/css"/>    
<link href="<?php echo static_url('static/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo static_url('static/js/jquery-2.1.4.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/bootstrap.min.js');?>" type="text/javascript"></script>

<body>

<?php $this->load->view('top_menu_view');?>
                                    
<div class="item">
    <img src="<?php echo static_url('static/images/join_bg.png')?>" alt="" style="width: 100%;height: 579px;">                     
        <div class="carousel_right">
            <ul class="qrcode">
                <li><h2>稳定货源，多赚钱，少操心<br/>统一管理，省开支，赢口碑<br/>做最受尊敬的车老板</h2></li>
            </ul>
            <ul class="app tube_app">
                <li><a href="javascript:;">申请成为车队货老板</a></li>
                <li><a href="<?php echo site_url('appdownload/TruckManager-release.apk')?>">下载途好运车队版App</a></li>
            </ul>
        </div><!--carousel_two_right-->
</div><!--item-->               

<div class="content_one">
    <div class="content_one_left join_one_right">
        <img src="<?php echo static_url('static/images/tube_img_2.png')?>"/> 
    </div>
    <div class="content_one_right join_one_left">
        <h2>做最受人尊敬的车老板</h2>
        <h3>多赚钱，少操心；省开支，赢口碑。</h3>
        <p>没货？途好运指派运单；路不熟？途好运卡车导航；油耗高？
            途好运免费培训驾驶习惯；换新车？途好运低价买车；没钱？
            途好运信用贷款。
        </p>
    </div>
</div><!--content_one-->

<div class="content_two">
    <div class="content_one_right" style="float:left;margin-left:80px;margin-right:-80px">
        <h2>运输轨迹  一目了然</h2>
        <h3>&nbsp;</h3>
        <p>司机一发车，货老板在家就能看车的轨迹；司机上报路上遇到的堵车
            大雨、路政罚款等给公司，货老板统统能接到通知；司机完成，货就
            到目的地了。客户也能用运单号来查询车辆位置
        </p>
    </div>
    <div class="content_two_right" style="margin-right:80px;">
        <img src="<?php echo static_url('static/images/join_img_1.png')?>" style="width:594px;
height:350px;"/> 
    </div>
</div><!--content_two-->


<div class="content_tree">
    <img src="<?php echo static_url('static/images/join_img_3.png')?>" />
</div><!--content_tree-->

<?php $this->load->view('text_bottom_view');?>

</body>

<?php $this->load->view('footer_view');?>