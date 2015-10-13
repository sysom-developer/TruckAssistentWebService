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
                    <a href="<?php echo site_url(''.$this->appfolder.'/vehicle_type/add_data')?>" class="add">添 加</a>
                </p>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>类型</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/vehicle_type/detail/'.$data['type_id'].'')?>"><?php echo $data['type_id']?></a></td>
                <td>
                    <?php echo $data['type_name']?>
                </td>
                <td>
                    <?php
                    $type_status = '';
                    switch ($data['type_status']) {
                        case 0:
                            $type_status = '<font color="red">无效</font>';
                            break;
                        case 1:
                            $type_status = '<font color="green">有效</font>';
                            break;
                    }
                    echo $type_status;
                    ?>
                </td>
                <td>
                    <?php echo $data['create_time']?>
                </td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/vehicle_type/edit_data/'.$data['type_id'].'')?>">编辑</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/vehicle_type/delete/'.$data['type_id'].'')?>';}">删除</a>
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