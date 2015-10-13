<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<body>
<div class="warrper">
<div class="content">
    
    <?php $this->load->view(''.$this->appfolder.'/path_view');?>

    <div class="shop">
        <div class="shop_content">
            <div class="search_box">
                <p>
                    <a href="javascript:;" onClick="javascript:window.history.back();" class="add">返 回</a>
                </p>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>日志类型</th>
                <th>日志备注</th>
                <th>操作管理员名称</th>
                <th>操作时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><?php echo $data['id']?></td>
                <td><?php echo get_admin_log_type($data['log_type'])?></td>
                <td><?php echo $data['log_remark']?></td>
                <td><a href="<?php echo site_url(''.$this->appfolder.'/admin/detail/'.$data['admin_id'].'')?>"><?php echo $data['admin_info']['username']?></a></td>
                <td><?php echo date("Y-m-d H:i:s", $data['cretime'])?></td>
                <td><a href="<?php echo site_url(''.$this->appfolder.'/admin_log/detail/'.$data['id'].'')?>">查看</a></td>
            </tr>
            <?php 
                }
            }
            ?>
        </table>
        <div class="pager">
            <span class="fun">
            <?php echo $links?>
            </span>
        </div>
    </div>
</div>
</div>
</body>
</html>