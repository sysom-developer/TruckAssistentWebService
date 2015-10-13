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
                <form method="get" action="<?php echo site_url(''.$this->appfolder.'/driver')?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100">司机姓名：</td>
                        <td><input type='text' class='txt' name='driver_name' value='<?php echo $driver_name?>'></td>
                    </tr>
                    <tr>
                        <td>手机号码：</td>
                        <td><input type='text' class='txt' name='driver_mobile' value='<?php echo $driver_mobile?>'></td>
                    </tr>
                    <tr>
                        <td>状态：</td>
                        <td>
                            <select name="driver_status">
                                <option value="1" <?php if ($driver_status == 1) { echo 'selected';}?>>有效</option>
                                <option value="2" <?php if ($driver_status == 2) { echo 'selected';}?>>无效</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:10px;">
                            <input type="submit" class="btn" value="搜 索" />
                            <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回">

                            <a href="javascript:;" onClick="javascript:window.history.back();" class="add">返 回</a>
                            <a href="<?php echo site_url(''.$this->appfolder.'/driver/add_data')?>" class="add">添 加</a>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    </div>
    <div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
                <td>有效司机数：<?php echo $valid_total?></td>
            </tr>
            <tr>
                <td>无效司机数：<?php echo $invalid_status?></td>
            </tr>
        </table>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>手机号</th>
                <th>等待时间</th>
                <th>头像照片</th>
                <th>身份证照片</th>
                <th>驾驶证照片</th>
                <th>行驶证照片</th>
                <th>司机照片</th>
                <th>认证状态</th>
                <th>状态</th>
                <th>当前积分</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/driver/detail/'.$data['driver_id'].'')?>"><?php echo $data['driver_id']?></a></td>
                <td><?php echo $data['driver_name']?></td>
                <td><?php echo $data['driver_mobile']?></td>
                <td><?php echo $data['exec_time']?></td>
                <td style="padding: 1px 0;">
                    <?php if ($data['driver_head_icon_http_file']) {?>
                    <a href="<?php echo $data['driver_head_icon_http_file']?>" target="_blank">查看<!-- <img src="<?php echo $data['driver_head_icon_http_file']?>" width="100" height="100"> --></a>
                    <?php } else { echo "-";}?>
                </td>
                <td>
                    <?php if ($data['driver_card_icon_http_file']) {?>
                    <a href="<?php echo $data['driver_card_icon_http_file']?>" target="_blank">查看<!-- <img src="<?php echo $data['driver_card_icon_http_file']?>" width="100" height="100"> --></a>
                    <?php } else { echo "-";}?>
                </td>
                <td>
                    <?php if ($data['driver_license_icon_http_file']) {?>
                    <a href="<?php echo $data['driver_license_icon_http_file']?>" target="_blank">查看<!-- <img src="<?php echo $data['driver_license_icon_http_file']?>" width="100" height="100"> --></a>
                    <?php } else { echo "-";}?>
                </td>
                <td>
                    <?php if ($data['driver_vehicle_license_icon_http_file']) {?>
                    <a href="<?php echo $data['driver_vehicle_license_icon_http_file']?>" target="_blank">查看<!-- <img src="<?php echo $data['driver_vehicle_license_icon_http_file']?>" width="100" height="100"> --></a>
                    <?php } else { echo "-";}?>
                </td>
                <td>
                    <?php if ($data['driver_pic_http_file']) {?>
                    <a href="<?php echo $data['driver_pic_http_file']?>" target="_blank">查看<!-- <img src="<?php echo $data['driver_pic_http_file']?>" width="100" height="100"> --></a>
                    <?php } else { echo "-";}?>
                </td>
                <td>
                    <?php
                    foreach ($config_driver_type as $key => $value) {
                        $color = 'red';
                        if ($key == 1) {
                            $color = 'green';
                        }
                        if ($key == $data['driver_type']) {
                            $driver_type = '<font color="'.$color.'">'.$value.'</font>';
                            echo $driver_type;
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $driver_status = '';
                    switch ($data['driver_status']) {
                        case 1:
                            $driver_status = '<font color="green">有效</font>';
                            break;
                        case 2:
                            $driver_status = '<font color="red">无效</font>';
                    }
                    echo $driver_status;
                    ?>
                </td>
                <td><?php echo $data['driver_score']?></td>
                <td>
                    <?php echo date('Y-m-d H:i:s', $data['create_time'])?>
                </td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/driver/edit_data/'.$data['driver_id'].'')?>">编辑</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/driver/delete/'.$data['driver_id'].'')?>';}">删除</a>
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