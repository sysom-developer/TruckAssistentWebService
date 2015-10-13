<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />

<script src="<?php echo base_url('static/js/ajaxfileupload.js');?>" type="text/javascript"></script>

<style type="text/css">
.opacity_file{
    opacity: 0;
    width: 256px;
    height: 45px;
    left: 145px;
    top: 0;
    position: absolute;
}
</style>


<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<?php $this->load->view($this->appfolder.'/member_left_view')?>

<div class="menber_right">
    <div class="exchange">
        <div class="exchange_box">
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_2.png')?>"/>
            <h4>50元手机话费充值</h4>
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_5.png')?>"style="width:15px;float:left;margin-top:6px"/>
            <p>500</p>
            <a href="#">兑换</a>
        </div>  
    </div>
    <div class="exchange">
        <div class="exchange_box">
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_3.png')?>"/>
            <h4>100元手机话费充值</h4>
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_5.png')?>"style="width:15px;float:left;margin-top:6px"/>
            <p>1000</p>
            <a href="#">兑换</a>
        </div>  
    </div>
    <div class="exchange">
        <div class="exchange_box">
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_3.png')?>"/>
            <h4>100元手机话费充值</h4>
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_5.png')?>"style="width:15px;float:left;margin-top:6px"/>
            <p>1000</p>
            <a href="#">兑换</a>
        </div>  
    </div>
    <div class="exchange">
        <div class="exchange_box">
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_3.png')?>"/>
            <h4>100元手机话费充值</h4>
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_5.png')?>"style="width:15px;float:left;margin-top:6px"/>
            <p>1000</p>
            <a href="#">兑换</a>
        </div>  
    </div>
    <div class="exchange">
        <div class="exchange_box">
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_3.png')?>"/>
            <h4>100元手机话费充值</h4>
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_5.png')?>"style="width:15px;float:left;margin-top:6px"/>
            <p>1000</p>
            <a href="#">兑换</a>
        </div>  
    </div>
    <div class="exchange">
        <div class="exchange_box">
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_3.png')?>"/>
            <h4>100元手机话费充值</h4>
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_5.png')?>"style="width:15px;float:left;margin-top:6px"/>
            <p>1000</p>
            <a href="#">兑换</a>
        </div>  
    </div>
</div>
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>