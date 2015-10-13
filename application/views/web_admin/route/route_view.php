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
                    <a href="<?php echo site_url(''.$this->appfolder.'/route/add_data')?>" class="add">添 加</a>
                </p>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>线路名称</th>
                <th>经过城市</th>
                <th>默认行驶需要时间（小时）</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/route/edit_data/'.$data['route_id'].'')?>"><?php echo $data['route_id']?></a></td>
                <td>
                    <?php echo $data['route_name']?>
                </td>
                <td>
                    <?php echo $data['route_points']?>
                </td>
                <td>
                    <?php echo $data['route_duration'] / 3600?> 小时
                </td>
                <td>
                    <?php
                    $route_status = '';
                    switch ($data['route_status']) {
                        case 1:
                            $route_status = '<font color="green">有效</font>';
                            break;
                        case 2:
                            $route_status = '<font color="red">无效</font>';
                            break;
                    }
                    echo $route_status;
                    ?>
                </td>
                <td><?php echo $data['route_time']?></td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/route/edit_data/'.$data['route_id'].'')?>">编辑</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/route/delete/'.$data['route_id'].'')?>';}">删除</a>
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