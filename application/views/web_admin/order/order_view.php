<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<!-- jquery ui -->
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui-timepicker-addon.css')?>">
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.ui.datepicker-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/address_autocomplete.js')?>"></script>

<script type="text/javascript">
$(function() {
    $("tr[name=data_list]").mousemove(function() {
        $("tr[name=data_list]").css("background-color", "#F5F5F5");
        $(this).css("background-color", "#E6E6E6");
    });

    $("input[name=start_time]").mousedown(function() {
        $(this).datepicker();
    });
    $("input[name=end_time]").mousedown(function() {
        $(this).datepicker();
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
                <form method="get" action="<?php echo site_url(''.$this->appfolder.'/order')?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100">运单号：</td>
                        <td><input type='text' class='txt' name='order_num' value='<?php echo $order_num?>'></td>
                    </tr>
                    <tr>
                        <td>司机姓名：</td>
                        <td><input type='text' class='txt' name='driver_name' value='<?php echo $driver_name?>'></td>
                    </tr>
                    <tr>
                        <td>发车开始时间：</td>
                        <td><input type="text" name="start_time" class="txt" value='<?php echo $start_time?>' readonly="readonly"></td>
                    </tr>
                    <tr>
                        <td>发车结束时间：</td>
                        <td><input type="text" name="end_time" class="txt" value='<?php echo $end_time?>' readonly="readonly"></td>
                    </tr>
                    <tr>
                        <td>当前状态：</td>
                        <td>
                            <select name="order_type">
                                <option value="0">全部</option>
                                <?php
                                foreach ($order_type_desc as $config_order_type => $config_order_type_desc) {
                                ?>
                                <option value="<?php echo $config_order_type?>" <?php if ($order_type == $config_order_type) { echo 'selected';}?>><?php echo $config_order_type_desc?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>是否有效：</td>
                        <td>
                            <select name="order_status">
                                <option value="1" <?php if ($order_status == 1) { echo 'selected';}?>>有效</option>
                                <option value="2" <?php if ($order_status == 2) { echo 'selected';}?>>无效</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:10px;">
                            <input type="submit" class="btn" value="搜 索" />
                            <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回">

                            <a href="javascript:;" onClick="javascript:window.history.back();" class="add">返 回</a>
                            <a href="<?php echo site_url(''.$this->appfolder.'/order/add_data')?>" class="add">添 加</a>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>运单号</th>
                <th>司机姓名</th>
                <th>出发地</th>
                <th>目的地</th>
                <th>当前位置</th>
                <th>发车时间</th>
                <th>运行时间</th>
                <th>预计到达时间</th>
                <th>当前状态</th>
                <th>是否有效</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/order/detail/'.$data['order_id'].'')?>"><?php echo $data['order_id']?></a></td>
                <td><?php echo $data['order_num']?></td>
                <td><?php echo $data['driver_data']['driver_name']."(".$data['driver_data']['driver_mobile'].")"?></td>
                <td><?php echo $data['order_start_city']?></td>
                <td><?php echo $data['order_end_city']?></td>
                <td><?php echo $data['current_location']?></td>
                <td><?php echo date('m-d H:i', $data['good_start_time'])?></td>
                <td><?php echo $data['exec_time']?></td>
                <td><?php echo date('m-d H:i', $data['good_end_time'])?></td>
                <td><?php echo $order_type_desc[$data['order_type']]?></td>
                <td>
                    <?php
                    $order_status = '';
                    switch ($data['order_status']) {
                        case 1:
                            $order_status = '<font color="green">有效</font>';
                            break;
                        case 2:
                            $order_status = '<font color="red">无效</font>';
                    }
                    echo $order_status;
                    ?>
                </td>
                <td>
                    <?php echo date('Y-m-d H:i:s', $data['create_time'])?>
                </td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/order/edit_data/?id='.$data['order_id'].'')?>">编辑</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/order/delete/?id='.$data['order_id'].'')?>';}">删除</a>
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