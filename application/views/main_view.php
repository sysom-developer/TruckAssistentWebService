<?php $this->load->view('header_view');?>

<link rel="stylesheet" href="<?php echo static_url('static/css/homepage.css')?>" type="text/css"/>    
<link href="<?php echo static_url('static/css/responsiveslides.css')?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.js')?>"></script>
<script src="<?php echo base_url('static/js/responsiveslides.min.js');?>"></script>

<script>
$(function() {
    $('#dowebok').responsiveSlides({
        auto: true,
        speed: 1000,
        timeout: 6000,
        pager: true,
        nav: true,
        namespace: 'centered-btns',
    });
});
</script>

<body style="overflow:hidden;">

<?php $this->load->view('top_menu_view');?>

<div class="wrap" >
    <ul class="rslides" id="dowebok">
        <li>
			<a href="javascript:;" target="_blank"><img src="<?php echo static_url('static/images/homepage_bg_1.png')?>" alt=""></a>

			<div class="item active">
				<div class="carousel_one">
					<div class="logo">
						<img src="<?php echo static_url('static/images/homepage_logo.png')?>" />
						<h1>智慧运输&nbsp;&nbsp;诚信必达</h1>
					</div>
				</div>
			</div>
			<!--item active-->
		</li>

        <li>
			<a href="javascript:;" target="_blank"><img src="<?php echo static_url('static/images/homepage_bg_2.png')?>" alt=""></a>
			<div class="item">
						<div class="carousel_two_left">
							<img src="<?php echo static_url('static/images/homepage_rec.png')?>" />
							<h1>做最省心的货老板</h1>
							<h2>透明运输&nbsp;&nbsp;&nbsp;全程监控</h2>
						</div><!--carousel_two_left-->
						<div class="carousel_two_right">
							<ul class="qrcode" style="width:170px;height:170px;margin:4px -2px;">
								<li><img src="<?php echo static_url('static/images/qr.png')?>"/></li>
								<li><p>扫描下载途好运司机端App</p></li>
							</ul>
							<ul class="app">
								<li><a href="<?php echo site_url('public_web_shipper/register')?>">注册途好运货老板</a></li>
								<li><a href="<?php echo site_url('appdownload/TruckManager-release.apk')?>">下载途好运司机App</a></li>
							</ul>
						</div><!--carousel_two_right-->
				</div>
				<!--item-->
		</li>

        <li>
			<a href="javascript:;" target="_blank"><img src="<?php echo static_url('static/images/homepage_bg_3.png')?>" alt=""></a>
			<div class="item">
						<div class="carousel_two_left">
							<img src="<?php echo static_url('static/images/homepage_rec.png')?>" />
							<h1>做最赚钱的车老板</h1>
							<h2>月月增收&nbsp;&nbsp;&nbsp;省心不烦</h2>
						</div><!--carousel_two_left-->
						<div class="carousel_two_right">
							<ul class="qrcode" style="width:170px;height:170px;margin:4px -2px;">
								<li><img src="<?php echo static_url('static/images/qr.png')?>"/></li>
								<li id="qrcode_p"><p>扫描下载途好运车队版</p></li>
							</ul>
							<ul class="app">
								<li><a href="<?php echo site_url('public_web_shipper/register')?>">申请成为车队货老板</a></li>
								<li><a href="<?php echo site_url('appdownload/TruckManager-release.apk')?>">下载途好运车队版App</a></li>
							</ul>
						</div><!--carousel_two_right-->
				</div>
				<!--item-->
		</li>
    </ul>

    <div class="abc"></div>
</div>
<div class="bottom">
    <img src="<?php echo static_url('static/images/homepage_bottom.png')?>" />
    <p>
        copyright@2015 上海麦速物联网信息科技有限公司 沪ICP备15022775号-2
        <br/>
        公司地址：上海市徐汇区钦州路100号上海市科技创业中心1号楼607室
        &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
        客服电话：021-61358385
    </p>
</div><!--bottom-->

</body>

<?php $this->load->view('footer_view');?>