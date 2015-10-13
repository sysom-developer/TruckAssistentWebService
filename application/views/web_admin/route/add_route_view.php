<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
$(function() {
    // 起点
    $("select[name=start_province_id]").change(function() {
        var id = $(this).val();

        if (id == 0) {
            $("select[name=start_city_id]").html('<option value="0">请选择市</option>');
            return false;
        }

        $.post(apppath + fetch_class + '/ajax_get_region', {id: id}, function(json) {
            if (json.code == 'success') {
                var option = '<option value="0">请选择市</option>';
                for (var i=0; i<json.data.length; i++) {
                    option += '<option value="'+json.data[i].id+'">'+json.data[i].region_name+'</option>';
                }

                $("select[name=start_city_id]").html(option);
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
    });

    // 终点
    $("select[name=end_province_id]").change(function() {
        var id = $(this).val();

        if (id == 0) {
            $("select[name=end_city_id]").html('<option value="0">请选择市</option>');
            return false;
        }

        $.post(apppath + fetch_class + '/ajax_get_region', {id: id}, function(json) {
            if (json.code == 'success') {
                var option = '<option value="0">请选择市</option>';
                for (var i=0; i<json.data.length; i++) {
                    option += '<option value="'+json.data[i].id+'">'+json.data[i].region_name+'</option>';
                }

                $("select[name=end_city_id]").html(option);
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
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
    <form action="<?php echo site_url(''.$this->appfolder.'/route/act_add_data')?>" method="post" enctype="multipart/form-data">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="120">起点：</td>
                <td>
                    <select name="start_province_id" style="width: auto;" class="sel">
                        <option value="0">请选择省</option>
                        <?php echo $get_region_options?>
                    </select>
                    <select name="start_city_id" style="width: auto;" class="sel">
                        <option value="0">请选择市</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>终点：</td>
                <td>
                    <select name="end_province_id" style="width: auto;" class="sel">
                        <option value="0">请选择省</option>
                        <?php echo $get_region_options?>
                    </select>
                    <select name="end_city_id" style="width: auto;" class="sel">
                        <option value="0">请选择市</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>经过城市：</td>
                <td><input type="text" class="txt" name="route_points"></td>
            </tr>
            <tr>
                <td>默认行驶预估时间：</td>
                <td>
                    <input type="text" class="txt" name="route_duration">
                    <span style="font-weight: bold; color: #FF0000;">直接填写小时数，例：36</span>
                </td>
            </tr>
            <tr>
                <td>状态：</td>
                <td>
                    <select name="route_status" style="width: auto;">
                        <option value="1" selected>有效</option>
                        <option value="2">无效</option>
                    </select>
                </td>
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