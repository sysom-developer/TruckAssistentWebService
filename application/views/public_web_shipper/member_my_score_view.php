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
	<div class="points">
		<img src="<?php echo static_url('static/images/'.$this->appfolder.'/member_img_1.png')?>"/>
		<p>当前积分：<span><?php echo $this->shipper_info['shipper_company_data']['shipper_company_score']?></span></p>
	</div>
</div>
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>