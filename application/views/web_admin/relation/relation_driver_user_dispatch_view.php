<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
var user_dispatch_id = "<?php echo $user_dispatch_id?>";
var offset = "<?php echo $offset?>";

$(function() {
    $("tr[name=data_list]").mousemove(function() {
        $(this).css("background-color", "#E6E6E6");
    });

    $("tr[name=data_list]").mouseout(function() {
        $(this).css("background-color", "#F5F5F5");
    });
});
</script>

<body>
<div class="warrper">
    <div class="content">
        <div class="table_box">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th>ID</th>
                    <th>调度ID</th>
                    <th>调度名称</th>
                    <th>调度手机号码</th>
                    <th>线路ID</th>
                    <th>线路名称</th>
                    <th>司机ID</th>
                    <th>司机名称</th>
                    <th>操作</th>
                </tr>
                <?php 
                if (!empty($data_list)) {
                    foreach ($data_list as $value) {
                ?>
                <tr name="data_list">
                    <td><?php echo $value['id']?></td>
                    <td><?php echo $value['user_dispatch_id']?></td>
                    <td><?php echo $value['user_dispatch_data']['username']?></td>
                    <td><?php echo $value['user_dispatch_data']['mobile_phone']?></td>
                    <td><?php echo $value['route_id']?></td>
                    <td><?php echo $value['route_data']['route_name']?></td>
                    <td><?php echo $value['driver_id']?></td>
                    <td><?php echo $value['driver_data']['driver_name']?></td>
                    <td>
                        <a href="<?php echo site_url(''.$this->appfolder.'/relation_driver_user_dispatch/delete_relation/?id='.$value['id'].'&user_dispatch_id='.$user_dispatch_id.'&offset='.$offset.'&fetch_method='.$this->router->fetch_method().'')?>">移除</a>
                    </td>
                </tr>
                <?php 
                    }
                }
                ?>
            </table>
            <div class="pager">
                <span class="fun">
                <?php echo isset($links) ? $links : ''?>
                </span>
            </div>
        </div>
    </div>
</div>
</body>
</html>