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
    <div class="rule">
        <ul>
            <li>1. 每天登录系统奖励50个积分，每天奖励一次</li>
            <li>2. 加入司机数目，新加入一个司机奖励10个积分每天没有上限，新加入的司机完成与货主关联的
    首次运单，奖励100个积分
    </li>
            <li>3. 录入运单数，每录入一单并指派给某个司机，奖励10个积分，每天没有上限</li>
            <li>备注：1个积分等于人民币0.1元</li>
        </ul>
    </div>
</div>
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>