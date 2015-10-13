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
                <form method="get" action="<?php echo site_url(''.$this->appfolder.'/sleep_vehicle_anomaly')?>">
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
                        <td>货运公司：</td>
                        <td>
                            <select name="company_id">
                                <option value="all">全部</option>
                                <?php echo $shipper_company_options?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:10px;">
                            <input type="submit" class="btn" value="搜 索" />
                            <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回">

                            <a href="javascript:;" onClick="javascript:window.history.back();" class="add">返 回</a>
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
                <th>司机姓名</th>
                <th>司机手机号码</th>
                <th>上次运单线路</th>
                <th>所在公司列表</th>
                <th>最后一次上报位置</th>
                <th>异常原因</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><?php echo $data['driver_name']?></td>
                <td><?php echo $data['driver_mobile']?></td>
                <td><?php echo $data['last_finished_order_data']['order_start_city'].'-'.$data['last_finished_order_data']['order_end_city']?></td>
                <td><?php echo $data['driver_company_data_list']?></td>
                <td><?php echo $data['current_location']?></td>
                <td><?php echo $data['anomaly_desc']?></td>
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