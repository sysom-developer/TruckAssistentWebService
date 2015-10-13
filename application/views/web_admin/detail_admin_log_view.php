<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<body>
<div class="warrper">
<div class="content">

    <?php $this->load->view(''.$this->appfolder.'/path_view');?>
    
    <div class="shop">
        <div class="shop_content">
            <div class="search_box">
                <p><strong><?php echo $path_name?></strong></p>
            </div>
        </div>
    </div>
    <div class="forms_box">
        <p>
            <label>ID：</label>
            <?php echo $data['id']?>
        </p>
        <p>
            <label>日志类型：</label>
            <?php echo get_admin_log_type($data['log_type'])?>
        </p>
        <p>
            <label>日志备注：</label>
            <?php echo $data['log_remark']?>
        </p>
        <p>
            <label>管理员名称：</label>
            <?php echo $data['admin_info']['username']?>
        </p>
        <p>
            <label>创建时间：</label>
            <?php echo date("Y-m-d H:i:s", $data['cretime'])?>
        </p>
        <p class="shop">
            <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回" />
        </p>
    </div>
</div>
</div>
</body>
</html>