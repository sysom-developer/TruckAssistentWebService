<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
var shipper_company_id = "<?php echo $shipper_company_id?>";
var fetch_method = "<?php echo $this->router->fetch_method()?>";
var offset = "<?php echo $offset?>";

$(function() {
    $("tr[name=data_list]").mousemove(function() {
        $(this).css("background-color", "#E6E6E6");
    });

    $("tr[name=data_list]").mouseout(function() {
        $(this).css("background-color", "#F5F5F5");
    });

    $("input[name=relation_handle]").click(function() {
        var driver_id = $(this).val();
        var chk_status = 0;
        if ($(this).prop("checked") == true) {
            chk_status = 1;
        }

        $.ajax({
            url: "<?php echo site_url('"+appfolder+"/relation_shipper_driver/ajax_relation_handle')?>",
            data: {shipper_company_id: shipper_company_id, driver_id: driver_id, chk_status: chk_status, fetch_method: fetch_method},
            dataType: 'json',
            type: 'post',
            success: function(json) {
                if (json.error != 1) {
                    alert("操作失败，请重新操作！");

                    error = json.error;
                    return false;
                }
                alert("操作成功！");
                parent.current_iframe.location.reload();
                parent.all_iframe.location.reload();
                window.location.href = "<?php echo site_url(''.$this->appfolder.'/relation_shipper_driver/"+fetch_method+"/?shipper_company_id="+shipper_company_id+"&per_page="+offset+"')?>";
            }
        });

        return true;
    });
});
</script>

<body>
<div class="warrper">
    <div class="content">
        <div class="table_box">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th>关联货运公司 <?php echo isset($shipper_company_data['shipper_company_name']) ? $shipper_company_data['shipper_company_name'] : ''?></th>
                    <th>ID</th>
                    <th>司机姓名</th>
                    <th>司机手机号码</th>
                    <th>创建时间</th>
                </tr>
                <?php 
                if (!empty($data_list)) {
                    foreach ($data_list as $value) {
                ?>
                <tr name="data_list">
                    <td><input type="checkbox" name="relation_handle" <?php echo $value['checked']?> value="<?php echo $value['driver_id']?>"></td>
                    <td><?php echo $value['driver_id']?></td>
                    <td><?php echo $value['driver_name']?></td>
                    <td><?php echo $value['driver_mobile']?></td>
                    <td><?php echo date('Y-m-d H:i:s', $value['create_time'])?></td>
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