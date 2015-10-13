<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
$(function() {
    // 解决浏览器自动记录表单数据 
    $("#add_form")[0].reset();

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
    <form id="add_form" name="add_form" action="<?php echo site_url(''.$this->appfolder.'/admin_department/act_add_data')?>" method="post">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100">所属上级部门：</td>
                <td>
                    <select name="parent_depart_id" size="20" style="height:auto; width:600px;">
                        <option value="0">顶级</option>
                        <?php echo $department_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>部门名称：</td>
                <td><input type="text" class="txt" name="depart_name" value="" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" class="btn" value="确 认" />
                    <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回" />
                </td>
            </tr>
        </table>
    </div>
    </form>
</div>
</div>
</body>
</html>