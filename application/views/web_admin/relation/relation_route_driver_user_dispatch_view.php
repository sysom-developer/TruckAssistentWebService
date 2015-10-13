<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
var user_dispatch_id = "<?php echo $user_dispatch_id?>";

$(function() {
    $(".relation_route_driver_user_dispatch").click(function() {
        $(this).attr("disabled", true);
        var route_id = $("select[name=route_id]").val();
        var driver_id = $("select[name=driver_id]").val();

        $.ajax({
            url: "<?php echo site_url('"+appfolder+"/relation_driver_user_dispatch/ajax_relation_handle')?>",
            data: {user_dispatch_id: user_dispatch_id, route_id: route_id, driver_id: driver_id},
            dataType: 'json',
            type: 'post',
            success: function(json) {
                $(".relation_route_driver_user_dispatch").removeAttr("disabled");
                if (json.error != 1) {
                    alert("操作失败，请重新操作！");

                    error = json.error;
                    return false;
                }
                alert("操作成功！");
                parent.current_iframe.location.reload();
            }
        });

        return true;
    });
});
</script>

<body>
<div class="warrper">
    <div class="content">
        <div class="forms_box">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100">所有线路：</td>
                    <td>
                        <select name="route_id">
                            <?php
                            if ($route_data_list) {
                                foreach ($route_data_list as $value) {
                            ?>
                            <option value="<?php echo $value['route_id']?>"><?php echo $value['route_name']?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>所有司机：</td>
                    <td>
                        <select name="driver_id">
                            <?php
                            if ($driver_data_list) {
                                foreach ($driver_data_list as $value) {
                            ?>
                            <option value="<?php echo $value['driver_id']?>"><?php echo $value['driver_name']?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" class="btn relation_route_driver_user_dispatch" value="关 联" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>