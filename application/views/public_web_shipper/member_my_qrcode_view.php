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

<div class="container">
    <div class="usercenter">
        <dl>
            <dd>&nbsp;</dd>
            <dt>
                <img src="<?php echo $filename?>" />
            </dt>
        </dl>
     </div>
</div>
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>