<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
$(function() {
    $("input[name=nav_id]").click(function() {
        var nav_id = $(this).val();
        var checkdStatus = $(this).prop("checked");

        if (checkdStatus == true) {
            $("input[other_name=menu_id_"+nav_id+"]").prop("checked", true);
            $(this).prop("checked", true);
        } else {
            $("input[other_name=menu_id_"+nav_id+"]").prop("checked", false);
            $(this).prop("checked", false);
        }
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
                <p><strong><?php echo $path_name?></strong></p>
            </div>
        </div>
    </div>
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100">所属上级部门：</td>
                <td>
                    <select name="parent_depart_id" size="20" style="height:auto; width:600px;" readonly>
                        <option value="0">顶级</option>
                        <?php echo $department_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>部门名称：</td>
                <td><?php echo $data['depart_name']?></td>
            </tr>
            <tr>
                <td>创建时间：</td>
                <td><?php echo date('Y-m-d H:i:s', $data['cretime'])?></td>
            </tr>
            <tr>
                <td>更新时间：</td>
                <td><?php echo date('Y-m-d H:i:s', $data['updatetime'])?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回" />
                </td>
            </tr>
        </table>
    </div>
</div>
</div>
</body>
</html>