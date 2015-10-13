<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
$(function() {
    $("tr[name=data_list]").mousemove(function() {
        $("tr[name=data_list]").css("background-color", "#F5F5F5");
        $(this).css("background-color", "#E6E6E6");
    });
});
</script>

<body>
<div class="warrper">
<div class="content">
    
    <?php $this->load->view(''.$this->appfolder.'/path_view');?>

    <div class="shop">
        <div class="shop_content">
            <div class="search_box">
                <p>
                    <a href="javascript:;" onClick="javascript:window.history.back();" class="add">返 回</a>
                    <a href="<?php echo site_url(''.$this->appfolder.'/user_dispatch/add_data')?>" class="add">添 加</a>
                </p>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>手机号码</th>
                <th>是否有效</th>
                <th>创建时间</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/user_dispatch/edit_data/'.$data['id'].'')?>"><?php echo $data['id']?></a></td>
                <td>
                    <?php echo $data['username']?>
                </td>
                <td>
                    <?php echo $data['mobile_phone']?>
                </td>
                <td>
                    <?php
                    $status = '';
                    switch ($data['status']) {
                        case 1:
                            $status = '<font color="green">有效</font>';
                            break;
                        case 2:
                            $status = '<font color="red">无效</font>';
                            break;
                    }
                    echo $status;
                    ?>
                </td>
                <td><?php echo date("Y-m-d H:i:s", $data['cretime'])?></td>
                <td><?php echo date("Y-m-d H:i:s", $data['updatetime'])?></td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/user_dispatch/edit_data/'.$data['id'].'')?>">编辑</a>
                    <!-- <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/user_dispatch/delete/'.$data['id'].'')?>';}">删除</a> -->
                </td>
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