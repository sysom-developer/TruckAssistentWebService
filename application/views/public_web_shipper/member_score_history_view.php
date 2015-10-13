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
    <div class="detailed">
        <ul style="margin-right:300px;">
            <li>每日登陆</li>
            <li>新加入一个司机</li>
            <li>司机完成首单</li>
            <li>录入新运单</li>
        </ul>
        <ul style="font-size:20px;color:red;">
            <li>+50</li>
            <li>+150</li>
            <li>+1150</li>
            <li>+50</li>
        </ul>
        <ul style="margin-left:100px;color:#d5d5d5;">
            <li>06-05&nbsp;10:00</li>
            <li>06-05&nbsp;10:00</li>
            <li>06-05&nbsp;10:00</li>
            <li>06-05&nbsp;10:00</li>
        </ul>
    </div>
</div>
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>