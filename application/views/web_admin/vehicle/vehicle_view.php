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
                    <a href="<?php echo site_url(''.$this->appfolder.'/vehicle/add_data')?>" class="add">添 加</a>
                </p>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>司机名称</th>
                <th>车牌号</th>
                <th>发动机号</th>
                <th>车头照</th>
                <th>类型</th>
                <th>宽（米）</th>
                <th>长（米）</th>
                <th>高（米）</th>
                <th>载重（吨）</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/vehicle_id/detail/'.$data['vehicle_id'].'')?>"><?php echo $data['vehicle_id']?></a></td>
                <td><?php echo $data['driver_data']['driver_name']?></td>
                <td><?php echo $data['vehicle_card_num']?></td>
                <td><?php echo $data['vehicle_engine']?></td>
                <td style="padding: 1px 0;">
                    <?php if ($data['vehicle_head_icon_http_file']) {?>
                    <a href="<?php echo $data['vehicle_head_icon_http_file']?>" target="_blank"><img src="<?php echo $data['vehicle_head_icon_http_file']?>" width="100" height="100"></a>
                    <?php }?>
                </td>
                <td>
                    <?php echo $data['vehicle_type_data']['type_name']?>
                </td>
                <td><?php echo $data['vehicle_width']?></td>
                <td><?php echo $data['vehicle_length_data']['length']?></td>
                <td><?php echo $data['vehicle_height']?></td>
                <td><?php echo $data['vehicle_load_data']['load']?></td>
                <td>
                    <?php
                    $vehicle_status = '';
                    switch ($data['vehicle_status']) {
                        case 1:
                            $vehicle_status = '<font color="green">有效</font>';
                            break;
                        case 2:
                            $vehicle_status = '<font color="red">无效</font>';
                    }
                    echo $vehicle_status;
                    ?>
                </td>
                <td>
                    <?php echo $data['create_time']?>
                </td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/vehicle/edit_data/'.$data['vehicle_id'].'')?>">编辑</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/vehicle/delete/'.$data['vehicle_id'].'')?>';}">删除</a>
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